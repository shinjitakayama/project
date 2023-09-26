<?php

namespace App\Http\Controllers;

use App\User;
use App\Item;
use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ItemsController extends Controller
{
   
    public function index(Request $request)
    {
        
        return view('item', [
            'user' => Auth::user(),
            'categories' => Item::all(),
        ]);
        
    }



//＝＝＝　　　登録　　＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    // 商品登録
    public function store(Request $request)
    {
        $newItem = new Item;
        $newItem->items_name = $request->items_name;
        $newItem->price = $request->price;
        $newItem->description = $request->description;
        $newItem->state = $request->state;
        $newItem->user_id = $request->user_id;
        // $newItem->hide_flg = $request->hide_flg;
        // $newItem->selling = $request->selling;
        $newItem->user_id = Auth::user()->id;
        // dd($newItem,$request);

        // ディレクトリ名
        $dir = 'sample';

        // アップロードされたファイル名を取得
        $file_name = $request->file('image')->getClientOriginalName();

        // 取得したファイル名で保存
        $request->file('image')->storeAs('public/' . $dir, $file_name);
        // ファイル情報をDBに保存
        $newItem->image = $request->image;
        $newItem->path = 'storage/' . $dir . '/' . $file_name;
        $newItem->save();

        return view('item');
    }

//＝＝＝　　　表示　　＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
    public function show($id)
    {
        // 特定のアイテムを取得
        $item = Item::find($id);
    
        // アイテムのuser_idを取得
        $userId = $item->user_id;
    
        // userテーブルから該当するユーザー情報を取得
        $user = User::find($userId);
    
        // アイテム情報とユーザー情報を連想配列に組み合わせる
        $itemAndUser = [
            'item' => $item,
            'user' => $user,
        ];
    
        // ビューにデータを渡して 'item_detail' ビューを表示
        return view('items_detail')->with($itemAndUser);
    }

//  商品編集画面 表示
    public function edit($id)
    {
        $item = Item::find($id);
        return view('items_edit', compact('item'));
    }


    // 商品編集処理
public function update(Request $request, $id)
{
    // 選択された商品を取得
    $item = Item::find($id);

    // 編集処理実行
    $item->items_name = $request->items_name;
    $item->price = $request->price;
    $item->description = $request->description;
    $item->image = $request->image;
    $item->state = $request->state;
    // $item->selling = $request->selling;

    $item->save();

    // ユーザー情報を取得
    $user = User::find($item->user_id);

    // 商品詳細画面へ
    return view('items_detail', compact('item', 'user'));
}


    // 商品削除
    public function destroy(Int $id)
    {
        // 選択された商品データを取得
        $item = Item::find($id);

        // 削除処理実行
        $item->delete();

        // 商品一覧画面へ
        return redirect('/home');    
    }

    // 売上一覧表示
    public function sales()
    {
        // ここで必要なデータを取得
        $user = Auth::user(); // ユーザー情報を取得
        $items = Item::where('user_id', $user->id)->get(); // ユーザーのアイテムを取得

        // 売上合計金額の初期値を設定
        $totalSalesAmount = 0;

        // ユーザーのアイテムデータをループして合計金額を計算
        foreach ($items as $item) {
            $totalSalesAmount += $item->price;
        }

        // 売上合計金額をビューに渡す
        return view('sales')->with(['user' => $user, 'items' => $items, 'totalSalesAmount' => $totalSalesAmount]);
    }


    // いいね
        public function ajaxlike(Request $request)
    {
        $id = Auth::user()->id;
        $post_id = $request->post_id;
        $like = new Favorite;
        $post = Item::findOrFail($post_id);

        // 空でない（既にいいねしている）なら
        if ($like->like_exist($id, $post_id)) {
            //likesテーブルのレコードを削除
            $like = Favorite::where('item_id', $post_id)->where('user_id', $id)->delete();
        } else {
            //空（まだ「いいね」していない）ならlikesテーブルに新しいレコードを作成する
            $like = new Favorite;
            $like->item_id = $request->post_id;
            $like->user_id = Auth::user()->id;
            $like->save();
        }

        //loadCountとすればリレーションの数を○○_countという形で取得できる（今回の場合はいいねの総数）
        $postLikesCount = $post->loadCount('favorites')->likes_count;

        //一つの変数にajaxに渡す値をまとめる
        //今回ぐらい少ない時は別にまとめなくてもいいけど一応。笑
        $json = [
            'postLikesCount' => $postLikesCount,
        ];
        //下記の記述でajaxに引数の値を返す
        return response()->json($json);
    }

    // 商品非表示
    public function toggleVisibility(Item $item)
    {
        // 商品の表示・非表示を切り替えるロジック
        $item->update(['hide_flg' => !$item->hide_flg]);

        return back(); // 一覧ページにリダイレクト
    }

    
}
