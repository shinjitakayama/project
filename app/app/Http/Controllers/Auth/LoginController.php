<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Favorite;
use App\Purchase;
use App\User;
use App\Item;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected function loggedOut(Request $request)
    {
    return redirect('/home');
    }

    // 未ログイン
    public function nologin()
    {
        $user = User::get();
        $item = Item::all();
        $favorite = new Favorite;

        return view('nologin', [
            'items' => $item,
            'users' => $user,
            'favorites'=>$favorite,
        ]);

    }
}
