<?php

namespace App\Filament\Shadpanel\Resources\Posts\Pages;

use App\Filament\Shadpanel\Resources\Posts\PostResource;
use App\Filament\Shadpanel\Resources\Posts\Schemas\EditPostForm;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return EditPostForm::configure($schema);
    }
}
