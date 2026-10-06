<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class DataCentre extends Model
{
    protected $fillable = [
        'name', 'slug', 'location', 'country', 'address', 'latitude', 'longitude',
        'short_description', 'full_description', 'hero_image', 'hero_video_url',
        'meta_title', 'meta_description', 'og_image',
        'cta_heading', 'cta_description', 'cta_button_text', 'cta_button_url',
        'sort_order', 'status', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_featured' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (DataCentre $dataCentre) {
            if (empty($dataCentre->slug) && filled($dataCentre->name)) {
                $dataCentre->slug = static::uniqueSlug(Str::slug($dataCentre->name));
            }
        });

        static::updating(function (DataCentre $dataCentre) {
            if ($dataCentre->isDirty('name') && ! $dataCentre->isDirty('slug')) {
                $dataCentre->slug = static::uniqueSlug(Str::slug($dataCentre->name), $dataCentre->id);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(DataCentreSpecification::class)->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(DataCentreFeature::class)->orderBy('sort_order');
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(DataCentreGallery::class)->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }

    public static function uniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base ?: 'data-centre';
        $original = $slug;
        $counter = 1;

        while (static::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $original.'-'.$counter++;
        }

        return $slug;
    }
}
