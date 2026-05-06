<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestaurantTable extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id', 'table_number', 'seats'];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
    public function reservations()
    {
        return $this->belongsToMany(
            Reservation::class,
            'reservation_tables',
            'restaurant_table_id',
            'reservation_id'
        );
    }
}
