<?php

use App\Models\AuditLog;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    /**
     * The audit log being displayed.
     */
    public ?AuditLog $auditLog = null;

    /**
     * Load the selected audit log.
     */
    public function mount(int $auditLogId): void
    {
        $this->auditLog = AuditLog::findOrFail($auditLogId);
    }

    /**
     * Normalized diff rows ready for rendering.
     *
     * @return list<array{field: string, old: string, new: string}>
     */
    #[Computed]
    public function diffItems(): array
    {
        $diff = $this->decodeJsonField($this->auditLog?->diff);

        if (! is_array($diff) || $diff === []) {
            return [];
        }

        $items = [];

        foreach ($diff as $field => $changes) {
            $oldVal = is_array($changes) ? ($changes['old'] ?? $changes['before'] ?? null) : null;
            $newVal = is_array($changes) ? ($changes['new'] ?? $changes['after'] ?? $changes) : $changes;

            $items[] = [
                'field' => (string) $field,
                'old' => $this->formatValue($oldVal),
                'new' => $this->formatValue($newVal),
            ];
        }

        return $items;
    }

    /**
     * Pretty-printed JSON string for additional properties.
     */
    #[Computed]
    public function formattedProperties(): ?string
    {
        $properties = $this->decodeJsonField($this->auditLog?->properties);

        if (! is_array($properties) || $properties === []) {
            return null;
        }

        $encoded = json_encode($properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $encoded !== false ? $encoded : null;
    }

    /**
     * Decode array or JSON string field safely.
     */
    private function decodeJsonField(mixed $value): mixed
    {
        if (is_array($value)) {
            return $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }

    /**
     * Format a diff value for display.
     */
    private function formatValue(mixed $val): string
    {
        if ($val === null) {
            return '-';
        }

        if (is_bool($val)) {
            return $val ? 'true' : 'false';
        }

        if (is_scalar($val)) {
            return (string) $val;
        }

        $encoded = json_encode($val, JSON_UNESCAPED_UNICODE);

        return $encoded !== false ? $encoded : '-';
    }
};
