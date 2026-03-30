<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
//Redirection
Route::redirect('/welcome', '/');

// Route::view('/home', 'home');
Route::view('/about', 'about')->name('about');

Route::get('/home/{name?}', function ($name = null) {
    return view('home', ['name' => $name]);
})->name('home');
