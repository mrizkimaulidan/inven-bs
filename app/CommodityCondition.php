<?php

namespace App;

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
     * Get the human-readable label for the condition.
     */
    public function label(): string
    {
        return match ($this) {
            self::GOOD => 'Baik',
            self::POOR => 'Kurang Baik',
            self::HEAVILY_DAMAGED => 'Rusak Berat',
        };
    }

    /**
     * Get the condition options for select inputs.
     *
     * @return array<int, string>
     */
    public static function options(): array
    {
        return [
            self::GOOD->value => self::GOOD->label(),
            self::POOR->value => self::POOR->label(),
            self::HEAVILY_DAMAGED->value => self::HEAVILY_DAMAGED->label(),
        ];
    }

    /**
     * Determine if the commodity is usable.
     */
    public function isUsable(): bool
    {
        return match ($this) {
            self::GOOD, self::POOR => true,
            self::HEAVILY_DAMAGED => false,
        };
    }
}
