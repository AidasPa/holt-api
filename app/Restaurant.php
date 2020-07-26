<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'title',
        'description',
        'rating',
        'phone_number',
        'avg_delivery_time',
        'address',
    ];
}
