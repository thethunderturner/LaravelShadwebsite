<?php

namespace App\Filament\Shadpanel\Resources\Posts\Tables;

use App\Enum\PostCategory;
use App\Enum\PostTags;
use App\Filament\Shadpanel\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Pages\Page;
use Livewire\Component;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GridTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Post::query())
            ->defaultSort('pubDate', 'desc')
            ->recordUrl(function (Post $record, Component $livewire) {
                if ($livewire instanceof Page) {
                    return PostResource::getUrl('view', ['record' => $record]);
                } else {
                    return route('blog.show', ['record' => $record]);
                }
            })
            ->columns([
                Stack::make([
                    TextColumn::make('title')
                        ->searchable()
                        ->formatStateUsing(fn (): string => ''),
                    View::make('filament.shadpanel.resources.posts.tables.post-card-column'),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->filters([
                SelectFilter::make('category')
                    ->native(false)
                    ->options(PostCategory::class),
                SelectFilter::make('tags')
                    ->multiple()
                    ->native(false)
                    ->options(PostTags::class)
                    ->query(function (Builder $query, array $data): Builder {
                        $values = $data['values'] ?? [];

                        if (empty($values)) {
                            return $query;
                        }

                        return $query->where(function (Builder $nested) use ($values): void {
                            foreach ($values as $tag) {
                                $nested->orWhereJsonContains('tags', $tag);
                            }
                        });
                    }),
            ])
            ->paginated([6, 12, 24])
            ->defaultPaginationPageOption(6);
    }
}
