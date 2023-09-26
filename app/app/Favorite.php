<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Item;

class Favorite extends Model
{

    protected $fillable = ['id', 'item_id', 'user_id'];

    // favoritesテーブル対itemsテーブル、１対１
    public function items() {
        return $this->hasOne('App\Item', 'item_id');
    }

    // favoritesテーブル対usersテーブル、1対多
    public function users() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    // いいね
    public function like_exist($id, $item_id) {
        return $this->where([['user_id', $id], ['item_id', $item_id]])->exists();
    }
}
