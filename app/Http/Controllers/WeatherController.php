<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    public function index(Request $request)
    {

        $cityNames = ['東京都', '愛知県', '大阪府'];

        $apiKey = config('services.weather.key');

        $method = "GET";
        $client = new Client();

        foreach ($cityNames as $cityName) {
            $url = "http://api.openweathermap.org/data/2.5/weather?units=metric&lang=ja&q=$cityName&appid=$apiKey";
            $response = $client->request($method, $url);
            $data[] = json_decode($response->getBody(), true);
        }

        return Inertia::render(
            'CityList',
            ['data' => $data],
        );
    }

    public function show(Request $request)
    {
        return Inertia::render(
            'CityShow',
        );
    }

}
