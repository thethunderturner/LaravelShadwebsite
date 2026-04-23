<?php

namespace App\Filament\Shadpanel\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make([
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->rule(Password::default())
                            ->required()
                            ->visibleOn('create'),
                        Group::make([
                            TextInput::make('new_password')
                                ->label('New Password')
                                ->password()
                                ->revealable()
                                ->rule(Password::default())
                                ->nullable()
                                ->dehydrated(false),
                            TextInput::make('new_password_confirmation')
                                ->label('Confirm New Password')
                                ->password()
                                ->revealable()
                                ->rule('required', fn ($get) => (bool) $get('new_password'))
                                ->same('new_password')
                                ->dehydrated(false),
                        ])->visibleOn('edit'),
                    ]),
                    Section::make([
                        TextEntry::make('created_at')
                            ->state(fn ($record) => $record?->created_at?->diffForHumans() ?? new HtmlString('&mdash;')),
                    ])->grow(false)->columns(3),
                ])->from('md'),
            ])->columns(1);
    }
}
