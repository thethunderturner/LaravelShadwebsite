<?php

namespace App\Filament\Shadpanel\Resources\Posts\Schemas;

use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make([
                        ImageEntry::make('image')
                            ->getStateUsing(fn ($record) => $record->image ? asset('images/'.$record->image) : null)
                            ->defaultImageUrl(asset('/images/default-image.png'))
                            ->extraImgAttributes(['class' => 'w-full max-w-full rounded-lg object-cover h-auto!'])
                            ->columnSpanFull(),
                        TextEntry::make('title')
                            ->columnSpanFull()
                            ->color('primary'),
                        TextEntry::make('description')
                            ->columnSpanFull()
                            ->color('primary'),
                        Section::make([
                            TextEntry::make('content')
                                ->state(fn ($record) => RichContentRenderer::make($record->content)->customBlocks([YoutubeBlock::class])->toHtml())
                                ->html()
                                ->prose()
                                ->columnSpanFull(),
                        ]),
                    ]),
                    Section::make([
                        TextEntry::make('category')
                            ->badge()
                            ->placeholder('None')
                            ->color('info'),
                        TextEntry::make('tags')
                            ->badge()
                            ->placeholder('None')
                            ->color('primary'),
                        TextEntry::make('pubDate')
                            ->dateTime(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])->grow(false)->columns(1),
                ])->from('md'),
            ])->columns(1);
    }
}
