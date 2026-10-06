<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageStatistic extends Model
{
    protected $fillable = ['number', 'label', 'description', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
