<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function fav(Request $request)
    {
        $user = Auth::user();

        $status = $request->status;
        $city_id = $request->city_id;

        $favorite = Favorite::where([
            ['user_id', $user->id],
            ['city_id', $city_id]
        ])->first();

        if ($status) {
            // trueならばレコードを削除,falseに変更
            Favorite::destroy($favorite->id);
            $result = false;
        } else {
            // falseならばレコードを追加,trueに変更
            $record = new Favorite();
            $record->fill(['city_id' => $city_id, 'user_id' => $user->id]);
            $record->save();
            $result = true;
        }

        return response()->json($result);
    }
}
