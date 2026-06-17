<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function index() {
        Redis::incr('landing-page-views');
    }

    public function show() {}

    public function update() {}
}
