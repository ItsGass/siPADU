<?php

namespace App\Enums;

enum SuggestionType: string
{
    case Saran = 'saran';
    case Kritik = 'kritik';

    public function label(): string
    {
        return match ($this) {
            self::Saran => 'Saran',
            self::Kritik => 'Kritik',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Saran => 'green',
            self::Kritik => 'amber',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Saran => 'light-bulb',
            self::Kritik => 'chat-bubble-left-right',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type) => [$type->value => $type->label()])
            ->all();
    }
}
