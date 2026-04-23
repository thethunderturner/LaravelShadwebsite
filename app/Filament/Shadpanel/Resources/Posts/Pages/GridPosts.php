<?php

namespace App\Filament\Shadpanel\Resources\Posts\Pages;

use App\Filament\Shadpanel\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GridPosts extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static string $resource = PostResource::class;

    protected string $view = 'filament.shadpanel.resources.posts.pages.grid-list';

    public function getMaxContentWidth(): Width|null|string
    {
        return Width::Full;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query())
            ->defaultSort('pubDate', 'desc')
            ->recordUrl(fn (Post $record): string => PostResource::getUrl('view', ['record' => $record]))
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
                    ->options(fn (): array => Post::query()
                        ->whereNotNull('category')
                        ->where('category', '!=', '')
                        ->distinct()
                        ->orderBy('category')
                        ->pluck('category', 'category')
                        ->all()
                    ),
                SelectFilter::make('tags')
                    ->multiple()
                    ->native(false)
                    ->options(fn (): array => Post::query()
                        ->whereNotNull('tags')
                        ->pluck('tags')
                        ->flatten()
                        ->filter()
                        ->unique()
                        ->sort()
                        ->mapWithKeys(fn (string $tag): array => [$tag => $tag])
                        ->all()
                    )
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
