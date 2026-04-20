<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['code', 'title', 'version', 'type', 'status', 'os', 'createdDate', 'updatedDate'])]
#[Table('compatibilitylist')]
class CompatibilityList extends Model
{
    public function db(): BelongsTo
    {
        return $this->belongsTo(CompatibilityDb::class, 'code', 'codedb');
    }

    protected function region(): Attribute
    {
        return Attribute::make(
            get: fn () => match (substr($this->db?->contentId ?? '', 0, 2)) {
                'UP' => 'USA',
                'EP' => 'Europe',
                'JP' => 'Japan',
                'HP' => 'Asia',
                'IP' => 'World',
                default => 'Unknown',
            }
        );
    }
}
