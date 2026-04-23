<?php

namespace App\Filament\Shadpanel\Resources\Users\Pages;

use App\Filament\Shadpanel\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
