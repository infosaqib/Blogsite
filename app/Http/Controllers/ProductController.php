<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return 'Products list';
    }
    public function show()
    {
        return 'Product successfully returned';
    }
    public function store()
    {
        return 'Product got stored';
    }
}
