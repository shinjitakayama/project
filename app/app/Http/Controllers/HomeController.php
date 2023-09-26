<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Item;
use App\Favorite;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // データ取得、商品一覧表示
    // データ取得、商品一覧表示
    public function index(Request $request)
    {
        // ユーザー情報を取得
        $user = Auth::user(); // ログイン中のユーザー情報を取得
        $favorite = new Favorite;
        $keyword = $request->input('keyword');
        $form = $request->input('form');
        $until = $request->input('until');
        $alluser = User::get();
        
        // Itemモデルのクエリを生成
        $itemQuery = Item::query();
    
        if (!empty($keyword)) {
            $itemQuery->where(function ($query) use ($keyword) {
                $query->where('items_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }
        
        // 金額の絞り込み
        if (!empty($form)) {
            $itemQuery->where('price', '>=', $form);
        }
        
        if (!empty($until)) {
            $itemQuery->where('price', '<', $until);
        }
    
        // 商品データ取得
        $items = $itemQuery->get();
    
        if($user->role == 0) {
            return view('admins', [
                'items' => $items,
                'users' => $user,
                'favorites' => $favorite,
                'form' => $form,
                'until' => $until,
                'alluser' => $alluser,
            ]);
        }

        return view('home', [
            'items' => $items,
            'users' => $user,
            'favorites' => $favorite,
            'form' => $form,
            'until' => $until,
        ]);
        
    }
    



        
    public function create(Request $request)
    {
        return view('mypage');
    }


}
