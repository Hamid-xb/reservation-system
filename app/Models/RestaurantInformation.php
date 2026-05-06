<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantInformation extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'address', 'email', 'phone_number'];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
}
