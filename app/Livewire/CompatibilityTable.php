<?php

namespace App\Livewire;

use App\Models\CompatibilityList;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class CompatibilityTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    // TODO: If search doesnt start with CUSA, then search by title, if search starts by CUSA search by CUSA
    public function table(Table $table): Table
    {
        return $table
            ->query(CompatibilityList::query()->with('db'))
            ->defaultSort('updated_at', 'desc')
//            ->recordUrl(function (Model $record) {
//                if ($record->id == 2442) {
//                    dd($record);
//                }
//            })
            ->recordUrl(fn (Model $record): string => "https://github.com/shadps4-compatibility/shadps4-game-compatibility/issues/{$record->id}")
            ->striped()
            ->openRecordUrlInNewTab()
            ->columns([
                ViewColumn::make('cusa_image')
                    ->label('Image')
                    ->view('filament.tables.columns.cusa-image'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => html_entity_decode($state)),
                TextColumn::make('code')
                    ->label('CUSA')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Playable' => 'success',
                        'Ingame' => 'info',
                        'Menus' => 'purple',
                        'Boots' => 'warning',
                        'Nothing' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                ViewColumn::make('os')
                    ->label('OS')
                    ->view('filament.tables.columns.os')
                    ->sortable(),
                TextColumn::make('version')
                    ->badge()
                    ->color('sky')
                    ->sortable(),
                ViewColumn::make('region')
                    ->label('Region')
                    ->view('filament.tables.columns.region'),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->native(false)
                    ->options([
                        'Playable' => 'Playable',
                        'Ingame' => 'Ingame',
                        'Menus' => 'Menus',
                        'Boots' => 'Boots',
                        'Nothing' => 'Nothing',
                    ]),
                SelectFilter::make('os')
                    ->label('OS')
                    ->native(false)
                    ->options([
                        'Windows' => 'Windows',
                        'Linux' => 'Linux',
                        'MacOS' => 'MacOS',
                    ]),
                SelectFilter::make('version')
                    ->native(false)
                    ->options(fn () => CompatibilityList::query()
                        ->whereNotNull('version')
                        ->where('version', '!=', '')
                        ->distinct()
                        ->orderByDesc('version')
                        ->pluck('version', 'version')
                        ->all()
                    ),
                SelectFilter::make('region')
                    ->native(false)
                    ->options([
                        'USA' => 'USA',
                        'Europe' => 'Europe',
                        'Japan' => 'Japan',
                        'Asia' => 'Asia',
                        'World' => 'World',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $prefix = match ($data['value'] ?? null) {
                            'USA' => 'UP',
                            'Europe' => 'EP',
                            'Japan' => 'JP',
                            'Asia' => 'HP',
                            'World' => 'IP',
                            default => null,
                        };

                        return $prefix
                            ? $query->whereHas('db', fn (Builder $q) => $q->where('contentId', 'like', $prefix.'%'))
                            : $query;
                    }),
            ])
            ->searchable();
    }

    public function render(): View
    {
        return view('livewire.compatibility-table');
    }
}
