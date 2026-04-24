<?php

namespace App\Filament\Shadpanel\Resources\Posts\Pages;

use App\Filament\Shadpanel\Resources\Posts\PostResource;
use App\Filament\Shadpanel\Resources\Posts\Schemas\CreatePostForm;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    public function form(Schema $schema): Schema
    {
        return CreatePostForm::configure($schema);
    }
}
