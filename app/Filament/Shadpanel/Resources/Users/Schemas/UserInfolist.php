<?php

namespace App\Filament\Shadpanel\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make([
                        TextEntry::make('name')
                            ->color('primary')
                            ->columnSpan(1)
                            ->label('Name'),
                        TextEntry::make('email')
                            ->color('primary')
                            ->columnSpan(1)
                            ->label('Email'),
                    ])->columns(2),
                    Section::make([
                        TextEntry::make('created_at')
                            ->state(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;')),
                    ])->grow(false)->columns(3),
                ])->from('md'),
            ])->columns(1);
    }
}
