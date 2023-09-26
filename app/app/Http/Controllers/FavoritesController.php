<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Item;
use App\Favorite;
use App\Purchase;

class FavoritesController extends Controller
{

    //  いいね一覧 
    public function favorite()
    {
        // ユーザー情報を取得
        $user = Auth::user();
    
        // favoriteテーブルからuser_idが一致するデータを取得し、連想配列に変換
        $favorite = Favorite::where('user_id', $user->id)->pluck('item_id')->toArray();
        // Itemテーブルからidが一致するアイテムを取得
        $items = Item::whereIn('id', $favorite)->get();
    
        // ビューにデータを渡して 'purchase_history' ビューを表示
        return view('favorite')->with(['user' => $user, 'items' => $items]);

        return view('favorite');
    }


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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

}
