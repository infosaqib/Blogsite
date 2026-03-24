<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreatePostRequest;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts', ['data' => $posts]);
    }
    public function show($post)
    {
        $posts = Post::find($post);
        return $posts;
    }

    public function searchPosts()
    {
        $post = Post::where('id', 1)->get();
        return $post;
    }

    public function store(CreatePostRequest $request)
    {
        $post = Post::create($request->all());
        return $post;
    }

    public function update(Request $request, $post)
    {
        $post = Post::find($post);
        $post->update($request->all());
        return $post;
    }

    public function destroy($post)
    {
        $post = Post::find($post);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully', $post]);
    }
}
