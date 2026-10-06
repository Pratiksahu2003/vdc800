<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataCentreSpecification extends Model
{
    protected $fillable = [
        'data_centre_id', 'label', 'value', 'unit', 'description', 'icon',
        'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function dataCentre(): BelongsTo
    {
        return $this->belongsTo(DataCentre::class);
    }
}
