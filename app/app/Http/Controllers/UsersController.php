<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Purchase;
use App\Item;
use App\Image;
use App\Relationship;

class UsersController extends Controller
{

    // ユーザー情報取得
    public function index(Request $request)
    {
        $id = Auth::user();

        return view('mypage')->with('user', $id);
    }


    public function create()
    {
  
    }


    public function store(Request $request)
    {
      
    }

    
    // ユーザーページ詳細画面　遷移
    public function show($id)
    {
        // 特定のユーザーを取得
        $user = User::find($id);
        $users = User::all(); // すべてのユーザー情報を取得
        $relationships = Relationship::all();
    
        // ユーザーが存在しない場合はエラーをハンドリングすることが重要です
        if (!$user) {
            return view('home'); 
        }
    
        // 'items' テーブルから 'user_id' カラムが $user のIDと一致する行を取得
        $items = Item::where('user_id', $user->id)->get();
    
        return view('users')->with(['user' => $user, 'items' => $items, 'users' => $users, 'relationships' => $relationships]);
    }

    // ユーザーページ編集画面　表示
    public function edit($id)
    {
        $user = User::find($id);
        return view('user_edit', compact('user'));
    }

    // マイページ編集　処理
    public function update(Request $request, $id)
    {
        // 選択されたユーザーを取得
        $user = User::find($id);

        // 編集処理実行
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;
        

        // ディレクトリ名
        $dir = 'sample';
        if (!empty($request->file('icon'))) {
        // アップロードされたファイル名を取得
        $file_name = $request->file('icon')->getClientOriginalName();
        
        // 取得したファイル名で保存
        $request->file('icon')->storeAs('public/' . $dir, $file_name);
        
        // ファイル情報をDBに保存
        $user->icon = $request->icon;
        $user->path = 'storage/' . $dir . '/' . $file_name;
        }
        $user->save();
        

        

        // 商品詳細画面へ
        // return view('users')->with('user', $user);
        return redirect()->route('user.show', $id);
    }

    public function destroy($id)
    {
        // 選択されたユーザーを取得
        $user = User::find($id);

        // 削除処理実行
        $user->delete();

        // ログイン画面へ
        return redirect()->route('login');
    }

    // ユーザー非表示
    public function toggleVisibility(User $user)
    {
        // ユーザーの表示・非表示を切り替えるロジック
        $user->update(['stop_flg' => !$user->stop_flg]);

        return back(); // ユーザー一覧ページにリダイレクト
    }

    
}
