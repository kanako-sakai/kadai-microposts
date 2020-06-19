<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    /**
     * ユーザをフォローする
    */
    public function store($id)
    {
        //認証済みのユーザがidのユーザをフォローする
        \Auth::user()->follow($id);
        //前のURLへリダイレクトさせる
        return back();
    }
    
    /**
     * ユーザをアンフォローする
     */
    public function destroy($id)
    {
        //認証済みのユーザがidのユーザをアンフォローする
        \Auth::user()->unfollow($id);
        //前のURLへリダイレクト
        return back();
    }
}
