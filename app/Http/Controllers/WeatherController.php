<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render(
            'CityList',
        );
    }

    public function show(Request $request)
    {
        return Inertia::render(
            'CityShow',
        );
    }

}
