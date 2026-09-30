<?php

namespace App\Enums;

enum MemberCategory: string
{
    case NWC = 'NWC';
    case NEC = 'NEC';
    case DEP = 'DEP';
    case STAFF = 'STAFF';
    case EST_STAFF = 'EST_STAFF';
    case PERSONAL_STAFF = 'PERSONAL_STAFF';

    /**
     * The name shown in the UI for this category.
     */
    public function label(): string
    {
        return match ($this) {
            self::NWC => 'NWC',
            self::NEC => 'NEC',
            self::DEP => 'DEPs',
            self::STAFF => 'Staff',
            self::EST_STAFF => 'EST Staff',
            self::PERSONAL_STAFF => 'Personal Staff',
        };
    }

    /**
     * The database enum values, in declaration order.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Category value => display label, for selects and menus.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
