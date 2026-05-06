<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpeningHour extends Model
{
    use HasFactory;

    protected $fillable = ['restaurant_id','day_of_week', 'open_time', 'close_time'];

    public function restaurant(){
        return $this->belongsTo(Restaurant::class);
    }
    public function scopeForDay($query, int $day)
    {
        return $query->where('day_of_week', $day);
    }
}
