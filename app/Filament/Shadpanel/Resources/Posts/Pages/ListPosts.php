<?php

namespace App\Filament\Shadpanel\Resources\Posts\Pages;

use App\Filament\Shadpanel\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('grid')
                ->label('Grid View')
                ->url(fn () => GridPosts::getNavigationUrl())
                ->icon(Heroicon::OutlinedSquares2x2)
                ->color('gray')
        ];
    }
}
