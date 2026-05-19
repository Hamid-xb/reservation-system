<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RestaurantType;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status', 'restaurant_type_id'];

    public function tables(){
        return $this->hasMany(RestaurantTable::class);
    }
    public function images(){
        return $this->hasMany(RestaurantImage::class);
    }
    public function openingHours(){
        return $this->hasMany(OpeningHour::class);
    }
    public function information(){
        return $this->hasOne(RestaurantInformation::class);
    }
    public function userRoles(){
        return $this->hasMany(UserRole::class);
    }
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
    public function logo()
    {
        return $this->hasOne(RestaurantImage::class)
            ->where('image_type', 'logo');
    }
    public function type()
    {
        return $this->belongsTo(RestaurantType::class, 'restaurant_type_id');
    }

    public function banner()
    {
        return $this->hasOne(RestaurantImage::class)
            ->where('image_type', 'banner');
    }
}
