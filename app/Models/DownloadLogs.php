<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['file_name', 'ip', 'timestamp'])]
class DownloadLogs extends Model
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
        ];
    }
}
