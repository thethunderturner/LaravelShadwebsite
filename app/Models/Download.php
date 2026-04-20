<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['file_name', 'release_date', 'file_url', 'count'])]
class Download extends Model
{
    //
}
