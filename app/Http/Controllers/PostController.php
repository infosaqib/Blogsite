<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function any(){
        echo 'any function called with method ';
        echo request()->method();
    }
    public function match(){
        echo 'match function called with method ';
        echo request()->method();
    }
}
