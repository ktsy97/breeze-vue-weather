<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Illuminate\Support\Facades\Request;

class WeatherController extends Controller
{
    public function list_view($city_ids)
    {
        $apiKey = config('services.weather.key');
        $method = "GET";
        $client = new Client();

        if (empty($city_ids)) {
            // 配列が空である場合
            $data = [];
        } else {
            // 配列が空でない場合
            foreach ($city_ids as $city_id) {
                $url = "http://api.openweathermap.org/data/2.5/weather?units=metric&lang=ja&id=$city_id&appid=$apiKey";
                $response = $client->request($method, $url);
                $data[] = json_decode($response->getBody(), true);
            }
        }

        return Inertia::render('CityList', [
            'data' => $data,
        ]);
    }

    public function index()
    {
        $user = Auth::user();

        // お気に入り
        $collection = Favorite::where('user_id', $user->id)->get();
        $city_ids = $collection->pluck('city_id')->toArray();

        $return = $this->list_view($city_ids);

        return $return;
    }

    public function select()
    {
        $user = Auth::user();

        switch (Request::get('area')) {
            case 1:
                // 北海道・東北
                // ['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県'];
                $city_ids = ['2130037', '2130656', '2112518', '2111888', '2113124', '2110554', '2112922'];
                break;
            case 2:
                // 関東・甲信
                // ['茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '山梨県', '長野県'];
                $city_ids = ['2112669', '1850310', '1863501', '1853226', '2113014', '1850144', '1860291', '1848649', '1856210'];
                break;
            case 3:
                // 北陸
                // ['新潟県', '富山県', '石川県', '福井県'];
                $city_ids = ['1855429', '1849872', '1861387', '1863983'];
                break;
            case 4:
                // 東海
                // ['愛知県', '岐阜県', '静岡県', '三重県'];
                $city_ids = ['1865694', '1863640', '1851715', '1857352'];
                break;
            case 5:
                // 近畿
                // ['大阪府', '兵庫県', '京都府', '滋賀県', '奈良県', '和歌山県'];
                $city_ids = ['1853904', '1862047', '1857907', '1852553', '1855608', '1848938'];
                break;
            case 6:
                // 中国
                // ['広島県', '岡山県', '山口県', '島根県', '鳥取県'];
                $city_ids = ['1862413', '1854381', '1848681', '1852442', '1849890'];
                break;
            case 7:
                // 四国
                // ['香川県', '徳島県', '愛媛県', '高知県'];
                $city_ids = ['1860834', '1850157', '1864226', '1859133'];
                break;
            case 8:
                // 沖縄
                // ['福岡県', '佐賀県', '長崎県', '大分県', '熊本県', '宮崎県', '鹿児島県', '沖縄県'];
                $city_ids = ['1863958', '1853299', '1856156', '1854484', '1858419', '1856710', '1860825', '1854345'];
                break;
            default:
                // お気に入り
                $collection = Favorite::where('user_id', $user->id)->get();
                $city_ids = $collection->pluck('city_id')->toArray();
                break;
        }

        $return = $this->list_view($city_ids);

        return $return;
    }

    public function show($city_id)
    {
        $user = Auth::user();

        $apiKey = config('services.weather.key');
        $method = "GET";
        $client = new Client();

        $current_url = "http://api.openweathermap.org/data/2.5/weather?units=metric&lang=ja&id=$city_id&appid=$apiKey";
        $current_response = $client->request($method, $current_url);
        $current = json_decode($current_response->getBody(), true);

        $forecast_url = "http://api.openweathermap.org/data/2.5/forecast?units=metric&lang=ja&id=$city_id&appid=$apiKey";
        $forecast_response = $client->request($method, $forecast_url);
        $forecast = json_decode($forecast_response->getBody(), true);

        // テーブルの日付のフォーマット
        foreach ($forecast["list"] as $item) {
            $date[] = date('Y/m/d H:i', $item["dt"]);
        }

        // chartのlabelとdata
        for ($i = 0; $i <= 7; $i++) {
            $chart_date[] = date('H:i', $forecast["list"][$i]["dt"]);
            $chart_temp[] = $forecast["list"][$i]["main"]["temp"];
        }

        $favorite = Favorite::where([
            ['user_id', $user->id],
            ['city_id', $city_id]
        ])->first();

        // favoriteされているか判定
        if (isset($favorite)) {
            // レコードが存在すれば、true
            $result = true;
        } else {
            // レコードが存在しなければ、false
            $result = false;
        }

        return Inertia::render('CityShow', [
            'current' => $current,
            'forecast' => $forecast,
            'date' => $date,
            'chart_date' => $chart_date,
            'chart_temp' => $chart_temp,
            'result' => $result,
            'city_id' => $city_id,
        ]);
    }
}
