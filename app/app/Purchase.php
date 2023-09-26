<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\User;

class Purchase extends Model
{
     // purchaseテーブル対itemsテーブル、1対１
     public function items() {
        return $this->hasOne('App\Item');
    }

     // purchaseテーブル対usersテーブル、多対１
     public function users() {
        return $this->belongsTo('App\User');
    }

    protected $table = 'purchase';
}
