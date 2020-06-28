<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * 投稿をお気に入りするアクション
     */
    public function store($micropost_id)
    {
        //認証済みのユーザが、投稿をお気に入りする
        \Auth::user()->favorite($micropost_id);
        //前のURLへリダイレクトする
        return back();
    }
    
    /**
     * 投稿をunfavoriteするアクション
     */
    public function destroy($micropost_id)
    {
        //認証済みのユーザが、投稿をunfavoriteする
        \Auth::user()->unfavorite($micropost_id);
        //前のURLへリダイレクトする
        return back();
    }
}
