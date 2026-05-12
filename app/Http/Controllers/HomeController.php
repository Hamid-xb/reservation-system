<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $restaurants = \App\Models\Restaurant::latest()->take(6)->get();

        return view('home', compact('restaurants'));
    }

    public function search()
    {
        $search = request()->input('name');
        $location = request()->input('location');
        $cuisine = request()->input('cuisine');

        $restaurants = \App\Models\Restaurant::query();

        if ($search) {
            $restaurants->where('name', 'like', "%{$search}%");
        }

        if ($location) {
            $restaurants->whereHas('information', function ($query) use ($location) {
                $query->where('address', 'like', "%{$location}%");
            });
        }

        if ($cuisine) {
            $restaurants->where('restaurant_type', $cuisine);
        }

        $restaurants = $restaurants->get();

        return view('home', compact('restaurants', 'search', 'location', 'cuisine'));
    }   
}
