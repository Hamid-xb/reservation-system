<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

     protected $fillable = ['name', 'scope'];

     public function userRoles(){
         return $this->hasMany(UserRole::class);
     }
}
