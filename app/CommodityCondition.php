<?php

namespace App;

/**
 * Enum for commodity conditions.
 *
 * Represents the physical condition of a commodity item.
 */
enum CommodityCondition: int
{
    /**
     * Commodity is in good condition, no defects.
     */
    case GOOD = 1;

    /**
     * Commodity is in poor condition, some defects visible.
     */
    case POOR = 2;

    /**
     * Commodity is heavily damaged, not usable.
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
     * Get all condition options for dropdown/select inputs.
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
     * Check if the commodity is usable/salable.
     */
    public function isUsable(): bool
    {
        return match ($this) {
            self::GOOD, self::POOR => true,
            self::HEAVILY_DAMAGED => false,
        };
    }
}
