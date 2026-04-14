<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Http::get("https://dummyjson.com/products");
        return view('product', ['products' => $products->json()['products']]);
    }
    public function show($id)
    {
        $product = Http::get("https://dummyjson.com/products/{$id}");
        return $product;
    }
    public function store()
    {
        return 'Product got stored';
    }
}
