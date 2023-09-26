<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use APP\Relationships;
use App\Purchase;
use App\Item;

class User extends Authenticatable
{
    use Notifiable;
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'stop_flg', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'stop_flg',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime', 'stop_flg', 
    ];



       // usersテーブル対itemsテーブル、１対多
       public function items() {
        return $this->hasMany('App\User');
    }

    // usersテーブル対purchaseテーブル、１対多
    public function purchase() {
        return $this->hasMany('App\Purchase');
    }

    // ユーザー削除に子要素追随
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // 'items' テーブルから 'user_id' カラムが $user のIDと一致する行を削除
            \DB::table('items')->where('user_id', $user->id)->delete();
        });

    }


    // いいね処理

     // usersテーブル対itemsテーブル、１対多
     public function favorites() {
        return $this->hasMany('App\User');
    }


    // フォロー、自身(follower_id)がフォローしているユーザー、多対多
    public function follows()
    {
        return $this->belongsToMany(User::class, 'relationships', 'follower_id', 'followed_id');
    }
    // フォロワー、自身(follower_id)がフォローされているユーザー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'relationships', 'followed_id', 'follower_id');
    }

    // フォロー状態確認
        public function isFollowing($userToCheck)
    {
        return $this->follows->contains($userToCheck);
    }


}
