<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use Illuminate\Support\Facades\Request;

class FavoriteController extends Controller
{
    public function fav()
    {
        $user = Auth::user();
        $city_id = Request::get('city_id');
        $status = Request::get('status');

        $favorite = $user->favorite()->where('city_id', $city_id);

        if ($status) {
            // trueならばレコードを削除,falseに変更
            $favorite->delete();

            $result = false;
        } else {
            // falseならばレコードを追加,trueに変更
            Favorite::create([
                'city_id' => $city_id,
                'user_id' => $user->id,
            ]);

            $result = true;
        }

        return response()->json($result);
    }
}
