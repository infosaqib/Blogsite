<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StorageController extends Controller
{
   public function index(){
        return view('upload');
   }
   public function upload(){
        return redirect('upload');
        echo 'Storage controller';
   }
}
