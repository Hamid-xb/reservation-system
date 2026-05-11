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
}
