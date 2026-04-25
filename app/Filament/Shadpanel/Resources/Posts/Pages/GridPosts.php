<?php

namespace App\Filament\Shadpanel\Resources\Posts\Pages;

use App\Filament\Shadpanel\Resources\Posts\PostResource;
use App\Filament\Shadpanel\Resources\Posts\Tables\GridTable;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class GridPosts extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = PostResource::class;

    protected string $view = 'filament.shadpanel.resources.posts.pages.grid-posts';

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::FitContent;
    }

    public function table(Table $table): Table
    {
        return GridTable::configure($table);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('list')
                ->label('List View')
                ->url(fn () => ListPosts::getNavigationUrl())
                ->icon(Heroicon::OutlinedQueueList)
                ->color('gray')
        ];
    }
}
