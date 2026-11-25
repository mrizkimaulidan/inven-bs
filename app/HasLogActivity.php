<?php

namespace App;

use App\Services\LogService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasLogActivity
{
    /**
     * Bootstrap the trait's Eloquent event listeners.
     */
    public static function bootHasLogActivity(): void
    {
        static::created(static function (Model $model): void {
            static::writeLog($model, 'created');
        });

        static::updated(static function (Model $model): void {
            static::writeLog($model, 'updated');
        });

        static::deleted(static function (Model $model): void {
            static::writeLog($model, 'deleted');
        });
    }

    /**
     * Persist an audit entry for the given model action.
     *
     * Only loggable attributes that actually changed are recorded.
     * If no loggable attribute changed during an update, nothing is written.
     *
     * @param  'created'|'updated'|'deleted'  $action
     */
    protected static function writeLog(Model $model, string $action): void
    {
        $loggable = method_exists($model, 'getLoggableAttributes')
            ? $model->getLoggableAttributes()
            : $model->getFillable();

        $excluded = method_exists($model, 'getLogExcludedAttributes')
            ? $model->getLogExcludedAttributes()
            : ['password', 'remember_token'];

        $logName = method_exists($model, 'getLogName')
            ? $model->getLogName()
            : 'data';

        /**
         * Extract only tracked attributes, excluding sensitive fields.
         *
         * @param  array<string, mixed>  $attributes
         * @return array<string, mixed>
         */
        $filter = static fn (array $attributes): array => collect($attributes)
            ->only($loggable)
            ->except($excluded)
            ->toArray();

        /** @var array<string, mixed> $rawOriginal */
        $rawOriginal = $model->getOriginal();

        /** @var array<string, mixed> $currentAttributes */
        $currentAttributes = $model->getAttributes();

        [$old, $new] = match ($action) {
            'created' => [[], $filter($currentAttributes)],
            'updated' => [
                $filter($rawOriginal),
                $filter($currentAttributes),
            ],
            'deleted' => [$filter($rawOriginal), []],
        };

        if ($action === 'updated') {
            $changed = array_keys($model->getChanges());

            $old = collect($old)->only($changed)->toArray();
            $new = collect($new)->only($changed)->toArray();

            if ($old === [] && $new === []) {
                return;
            }
        }

        /** @var array<string, array{old: mixed, new: mixed}> $diff */
        $diff = [];
        $fields = array_unique(array_merge(array_keys($old), array_keys($new)));

        foreach ($fields as $field) {
            $fieldKey = (string) $field;

            $diff[$fieldKey] = [
                'old' => $old[$fieldKey] ?? null,
                'new' => $new[$fieldKey] ?? null,
            ];
        }

        app(LogService::class)->log(
            event: "{$model->getMorphClass()}.{$action}",
            description: Str::headline(class_basename($model)." {$action}"),
            subject: $model,
            diff: $diff,
            logName: $logName,
        );
    }

    /**
     * Get the attributes that should be tracked in the audit log.
     *
     * Override by declaring a `$loggable` property on the model.
     * Defaults to the model's fillable attributes.
     *
     * @return array<int, string>
     */
    public function getLoggableAttributes(): array
    {
        if (property_exists($this, 'loggable') && is_array($this->loggable)) {
            /** @var array<int, string> */
            return $this->loggable;
        }

        return $this->getFillable();
    }

    /**
     * Get the attributes that should never be written to the audit log.
     *
     * Override by declaring a `$logExcluded` property on the model.
     * Defaults to credential-related fields.
     *
     * @return array<int, string>
     */
    public function getLogExcludedAttributes(): array
    {
        if (property_exists($this, 'logExcluded') && is_array($this->logExcluded)) {
            /** @var array<int, string> */
            return $this->logExcluded;
        }

        return ['password', 'remember_token'];
    }

    /**
     * Get the logical log channel used for categorizing entries.
     *
     * Override by declaring a `$logName` property on the model.
     * Defaults to 'data'.
     */
    public function getLogName(): string
    {
        if (property_exists($this, 'logName') && is_string($this->logName) && $this->logName !== '') {
            return $this->logName;
        }

        return 'data';
    }
}
