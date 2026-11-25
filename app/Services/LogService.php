<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AuditLog;
use BackedEnum;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Stringable;

/**
 * Record structured audit log entries with sensitive field masking and subject label resolution.
 */
#[Singleton]
readonly class LogService
{
    /**
     * Sensitive attribute keys that must never be stored in plain text.
     *
     * @var list<string>
     */
    private const array SENSITIVE_KEYS = [
        'password',
        'password_confirmation',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'api_key',
        'api_secret',
        'token',
        'secret',
        'card_number',
    ];

    /**
     * Write a single audit log entry.
     *
     * @param  string  $event  Stable event code, e.g. 'commodity.created'.
     * @param  string|null  $description  Human-readable summary.
     * @param  Model|null  $subject  The model affected by the action.
     * @param  Model|null  $causer  The actor; defaults to the authenticated user.
     * @param  array<string, mixed>  $diff  Attribute changes in { field: { old, new } } format.
     * @param  array<string, mixed>  $properties  Additional structured context.
     * @param  string  $logName  Logical channel name.
     */
    public function log(
        string $event,
        ?string $description = null,
        ?Model $subject = null,
        ?Model $causer = null,
        array $diff = [],
        array $properties = [],
        string $logName = 'default',
    ): AuditLog {
        $actor = $causer ?? auth()->user();
        $actorModel = $actor instanceof Model ? $actor : null;

        $rawCauserName = $actorModel?->getAttribute('name');
        $causerName = (is_scalar($rawCauserName) || $rawCauserName instanceof Stringable)
            ? (string) $rawCauserName
            : null;

        $maskedDiff = $this->mask($diff);
        $maskedProperties = $this->mask($properties);

        $isConsole = app()->runningInConsole();
        $userAgent = $isConsole ? null : Str::limit((string) request()->userAgent(), 500);
        $requestUrl = $isConsole ? null : Str::limit(request()->fullUrl(), 2000);

        return AuditLog::create([
            'log_name' => $logName,
            'event' => $event,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'subject_label' => $this->label($subject),
            'causer_type' => $actorModel?->getMorphClass(),
            'causer_id' => $actorModel?->getKey(),
            'causer_name' => $causerName,
            'diff' => $maskedDiff !== [] ? $maskedDiff : null,
            'properties' => $maskedProperties !== [] ? $maskedProperties : null,
            'ip_address' => $isConsole ? null : request()->ip(),
            'user_agent' => $userAgent,
            'request_url' => $requestUrl,
            'created_at' => now(),
        ]);
    }

    /**
     * Resolve a human-readable label for the given model.
     *
     * Tries common label attributes before falling back to class name and ID.
     */
    private function label(?Model $model): ?string
    {
        if (! $model instanceof Model) {
            return null;
        }

        foreach (['name', 'title', 'label', 'code'] as $attribute) {
            $value = $model->getAttribute($attribute);

            if ($value instanceof BackedEnum) {
                $value = $value->value;
            }

            if ((is_scalar($value) || $value instanceof Stringable) && (string) $value !== '') {
                return (string) $value;
            }
        }

        $key = $model->getKey();

        return class_basename($model).'#'.(is_scalar($key) ? (string) $key : '');
    }

    /**
     * Recursively mask sensitive values within the given array.
     *
     * @param  array<mixed, mixed>  $data
     * @return array<mixed, mixed>
     */
    private function mask(array $data): array
    {
        $masked = [];

        foreach ($data as $key => $value) {
            if (is_string($key) && in_array(strtolower($key), self::SENSITIVE_KEYS, true)) {
                $masked[$key] = '[REDACTED]';

                continue;
            }

            $masked[$key] = is_array($value) ? $this->mask($value) : $value;
        }

        return $masked;
    }
}
