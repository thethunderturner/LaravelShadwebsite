<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['snapshot_date', 'os', 'playable', 'ingame', 'menus', 'boots', 'nothing'])]
class CompatibilitySnapshots extends Model
{
    //
}
