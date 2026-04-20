<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['codedb', 'titledb', 'parentalLevel', 'contentId', 'category', 'psVr', 'neoEnable'])]
#[Table('compatibilitydb')]
class CompatibilityDb extends Model
{
    //
}
