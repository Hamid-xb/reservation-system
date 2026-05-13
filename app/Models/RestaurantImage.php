<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'image_url',
        'image_type',
        'sort_order',
    ];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
