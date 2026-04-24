<?php

namespace App\Enum;

use Filament\Support\Contracts\HasLabel;

enum PostCategory: string implements HasLabel
{
    case Developing = 'Developing';
    case News = 'News';
    case Releases = 'Releases';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
