<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) { //承認済みの場合
            //承認済みのユーザを取得
            $user = \Auth::user();
            //ユーザの投稿の一覧を作成日時の降順で取得
            $microposts=$user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
    
    //Welcomeビューでそれらを表示
    return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'content' => 'required|max:255',
        ]);
        
        //認証済みユーザの投稿として作成
        $request->user()->microposts()->create([
            'content'=>$request->content,
        ]);
        
        //前のURLへリダイレクトさせる
        return back();
    }
    
    public function destroy($id)
    {
        //idの値で投稿を検索して取得
        $micropost = \App\Micropost::findOrFail($id);
        
        //認証済みユーザがその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }
        
        //前のURLでリダイレクト
        return back();
    }
    
    public function show($id)
    {
        //idの値でユーザを検索して取得
        $user = User::findOrFail($id);
        
        //関係するモデルの件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザの投稿一覧を作成日時の降順で取得
        $microposts=$user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        //ユーザ詳細ビューでそれらを表示
        return view('users.show', [
            'user'=> $user,
            'microposts'=>$microposts,
        ]);
    }
}    
