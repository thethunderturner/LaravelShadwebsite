<?php

namespace App\Filament\Shadpanel\Resources\Posts\Schemas;

use App\Enum\PostCategory;
use App\Enum\PostTags;
use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CreatePostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make([
                        CuratorPicker::make('image')
                            ->disk('public_images')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('title')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->required()
                            ->customBlocks([
                                YoutubeBlock::class,
                            ])
                            ->columnSpanFull(),
                    ]),
                    Section::make([
                        Select::make('category')
                            ->native(false)
                            ->options(PostCategory::class)
                            ->required(),
                        Select::make('tags')
                            ->native(false)
                            ->options(PostTags::class)
                            ->multiple(),
                        DateTimePicker::make('pubDate')
                            ->native(false)
                            ->disabled()
                            ->dehydrated()
                            ->default(now()),
                    ])->grow(false)->columns(1),
                ])->from('md'),
            ])->columns(1);
    }
}
