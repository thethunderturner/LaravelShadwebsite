<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['file_name', 'os', 'type', 'version', 'release_date', 'file_url', 'count'])]
class Download extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
        ];
    }
}
