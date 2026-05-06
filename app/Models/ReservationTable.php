<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationTable extends Model
{

    protected $fillable = ['reservation_id', 'restaurant_table_id'];

    public function reservation(){
        return $this->belongsTo(Reservation::class);
    }
    public function restaurantTable(){
        return $this->belongsTo(RestaurantTable::class);
    }
}
