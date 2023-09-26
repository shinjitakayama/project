<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Relationship;
use App\Favorite;
use App\Purchase;
use App\User;
use App\Item;

class RelationshipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // {
        //     Auth::user()->relationships()->attach($id);
        //     return view('follow');
        // }
    }

    
    // 下記フォロー
    // 遷移
public function show($id)
{
    $user = Auth::user(); // ログインしているユーザーの情報を取得
    $users = User::all(); // すべてのユーザー情報を取得
    $relationships = Relationship::all();

    return view('follow_show', ['user' => $user, 'users' => $users, 'relationships' => $relationships]);
    return view('user_follow', ['user' => $user, 'users' => $users, 'relationships' => $relationships]);

}

    public function follow(Request $request)
{
    // フォローの処理を実行
    $userIdToFollow = $request->input('id');
    Auth::user()->follows()->attach($userIdToFollow);

    return redirect()->back();
}

public function remove(Request $request)
{
    // フォロー解除の処理を実行
    $userIdToRemove = $request->input('id');
    Auth::user()->follows()->detach($userIdToRemove);

    return redirect()->back();
}

//  フォロー　一覧 
public function showlist()
{
    // ユーザー情報を取得
    $user = Auth::user();

    // relationshipsテーブルからuser_idが一致するデータを取得し、連想配列に変換
    $follow = Relationship::where('follower_id', $user->id)->pluck('followed_id')->toArray();
    // Userテーブルからidが一致するユユーザーを取得
    $users = User::whereIn('id', $follow)->get();

    // ビューにデータを渡して 'followlist' ビューを表示
    return view('followlist')->with(['user' => $user, 'users' => $users]);

    return view('followlist');
}





    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
