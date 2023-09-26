<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ItemsController;
use App\Purchase;
use App\Item;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
  
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $item_id = $request->item_id;
        // dd($item_id);
        return view ('purchase',[
            'item_id' => $item_id,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 購入者情報内容保存処理
        $purchase = new Purchase;
        $purchase->users_name = $request->users_name;
        $purchase->tel = $request->tel;
        $purchase->postal_code = $request->postal_code;
        $purchase->address = $request->address;
        $purchase->user_id = Auth::user()->id;
        //商品id取得、購入テーブル代入
        $purchase->item_id = $request->item_id;

        // 購入時、商品sellingカラム1に変更　　1＝売却済み
        $items = new Item;
        $item = $items->where('id', '=', $request->item_id)->first();
        $item->selling = 1;
        $item->save();
        $purchase->save();

        return redirect('/home'); 
    }


    public function show($id)
    {
        // ユーザー情報を取得
        $user = Auth::user();
    
        // Purchaseテーブルからuser_idが一致するデータを取得し、連想配列に変換
        $purchase = Purchase::where('user_id', $user->id)->pluck('item_id')->toArray();
    
        // Itemテーブルからidが一致するアイテムを取得
        $items = Item::whereIn('id', $purchase)->get();
    
        // ビューにデータを渡して 'purchase_history' ビューを表示
        return view('purchase_history')->with(['user' => $user, 'items' => $items, ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

}
