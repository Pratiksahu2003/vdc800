<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataCentreGallery extends Model
{
    protected $table = 'data_centre_gallery';

    protected $fillable = [
        'data_centre_id', 'image', 'caption', 'alt_text', 'sort_order', 'is_active',
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
