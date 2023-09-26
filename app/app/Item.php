<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Purchase;
use App\Favorite;
use App\User;


class Item extends Model
{
    // itemsテーブル対usersテーブル、多対１
    public function users() {
        return $this->belongsTo('App\User');
    }

    // itemsテーブル対purchaseテーブル、１対１
    public function purchase() {
        return $this->hasOne('App\Purchase');
    }

    // itemsテーブル対favoritesテーブル、１対多
    public function favorites() {
        return $this->hasMany('App\Favorite');
    }

    protected $fillable = [
    // 他のカラム名
    'hide_flg',
    'selling',

];

}
