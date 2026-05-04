<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function any()
    {
        echo 'any function called with method ';
        echo request()->method();
    }
    public function match()
    {
        echo 'match function called with method ';
        echo request()->method();
    }
    public function getAllPosts()
    {
      return Post::select('title', 'description')->get(); //Objects
        // return Post::pluck('title'); // Array of titles
    }
    public function orderedPosts()
    {
        return Post::orderBy('title', 'asc')->get();
    }
    public function getPostById(Request $request)
    {
        // return Post::find($request->id);
        return Post::findOrFail($request->id);
    }
    public function getFirstPost()
    {
        return Post::select('title', 'description')->first();
    }
    public function searchPosts()
    {
        return Post::where('title', 'Rose')
        ->orWhere('description', 'Lorem')
        ->get();
    }
    public function LimitedPosts(Request $request)
    {
        return Post::limit($request->limit)->get();
    }
    public function createPost()
    {
        return Post::create([
            'title' => 'Rose',
            'description' => 'King of flowers',
            'image' => 'https://unsplash.com/?search=rose'
        ]);
    }
    public function updatePosts()
    {
        Post::where('id', 3)->update(['title' => 'Earch']);
    }
    public function deletePosts()
    {
        // Post::where('id', 2)->delete();
        Post::destroy(1);
        echo 'Post Deleted';
    }
}
