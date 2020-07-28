<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MenuItem extends Model
{
    protected $fillable = [
        'title', 'description', 'price'
    ];

    /**
     * @return HasOne
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id', 'id', 'menu_categories');
    }
}
