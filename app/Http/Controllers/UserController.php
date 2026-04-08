<?php

namespace App\Http\Controllers;

use App\Rules\Uppercase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    public function getUser($name)
    {
        $users = ['bilal', 'zain', 'uzair'];
        return view('user', ['name' => $name, 'users' => $users]);
    }
    public function login()
    {
        if (View::exists('auth.login')) {
            return view('auth.login');
        } else {
            echo 'No View Found';
        }
    }
    public function register()
    {
        if (View::exists('auth.register')) {
            return view('auth.register');
        } else {
            echo 'No View Found';
        }
    }

    public function loginUser(Request $request)
    {
        return $request;
    }
    public function addUser(Request $request)
    {
        $request->validate([
            'name' => ['required' , 'min:3' , 'max:6', new Uppercase()],
            'email' => 'required | email',
            'gender' => 'required',
            'country' => 'required',
            'hobbies' => 'required',
        ],[
            'name.required'=>'The name field can not be empty',
            'name.min'=>'The name field should not less than 3 characters'
        ]);
        return $request;
    }
}
