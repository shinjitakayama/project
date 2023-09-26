<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestMail extends Controller
{
    Mail::to('11111@test.com')

    ->send(new TestMail());

}
