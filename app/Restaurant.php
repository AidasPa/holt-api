<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Restaurant extends Model
{
    protected $fillable = [
        'title',
        'description',
        'rating',
        'phone_number',
        'avg_delivery_time',
        'address',
        'image',
        'banner',
        'image_blurhash',
        'banner_blurhash',
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_restaurant');
    }
}
