<?php

namespace App\Filament\Shadpanel\Resources\Posts\Pages;

use App\Filament\Shadpanel\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class GridPosts extends Page implements HasActions, HasSchemas, HasTable

{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;
    protected static string $resource = PostResource::class;

    protected string $view = 'filament.shadpanel.resources.posts.pages.grid-list';

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query())
            ->columns([
                Stack::make([
                    // Columns
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ]);
    }
}
