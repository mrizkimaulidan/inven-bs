<?php

namespace App\Enums;

/**
 * Represent the physical condition of a commodity.
 */
enum CommodityCondition: int
{
    /**
     * The commodity is in good condition.
     */
    case GOOD = 1;

    /**
     * The commodity is in poor condition.
     */
    case POOR = 2;

    /**
     * The commodity is heavily damaged.
     */
    case HEAVILY_DAMAGED = 3;

    /**
     * Human-readable label mapping keyed by enum value.
     *
     * @var array<int, string>
     */
    private const LABELS = [
        self::GOOD->value => 'Baik',
        self::POOR->value => 'Kurang Baik',
        self::HEAVILY_DAMAGED->value => 'Rusak Berat',
    ];

    /**
     * Get the human-readable label for the condition.
     */
    public function label(): string
    {
        return self::LABELS[$this->value];
    }

    /**
     * Resolve the enum case from its human-readable label.
     */
    public static function fromLabel(string $label): ?self
    {
        $value = array_search($label, self::LABELS, true);

        return $value === false ? null : self::from($value);
    }

    /**
     * Get the commodity condition options for select inputs.
     *
     * @return array<int, string>
     */
    public static function options(): array
    {
        return self::LABELS;
    }

    /**
     * Get all raw enum values.
     *
     * @return list<int>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Determine whether the commodity is still usable.
     */
    public function isUsable(): bool
    {
        return $this !== self::HEAVILY_DAMAGED;
    }
}
