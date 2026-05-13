<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['created_by_user_id', 'restaurant_id', 'name',
        'phone_number', 'number_of_people',
        'start_datetime', 'end_datetime',
        'status', 'reservation_type', 'reservation_note'
    ];
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    public function reservationTables(){
        return $this->hasMany(ReservationTable::class);
    }
    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
    public function createdByUser(){
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function tables()
    {
        return $this->belongsToMany(
            RestaurantTable::class,
            'reservation_tables',
            'reservation_id',
            'restaurant_table_id'
        );
    }
}
