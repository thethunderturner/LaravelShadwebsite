<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum PostTags: string implements HasLabel
{
    case GameFixes = 'Game Fixes';
    case Speed = 'Speed Increase';
    case Features = 'Features';
    case GameProgress = 'Game Progress';
    case Other = 'Other Features';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GameFixes => 'Game Fixes',
            self::Speed => 'Speed Increase',
            self::Features => 'Features',
            self::GameProgress => 'Game Progress',
            self::Other => 'Other Features',
        };
    }
}
