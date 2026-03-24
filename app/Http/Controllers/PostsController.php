<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->get();
        return  $posts;
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

        $data = $request->only(['title', 'body', 'userId']);
        $data['title'] = trim($data['title']);
        $post = Post::create($data);
        return $post;
    }

    public function update(UpdatePostRequest $request, $post)
    {
        $data = $request->only(['title', 'body']);
        $post = Post::find($post);
        $post->update($data);
        return $post;
    }

    public function destroy($post)
    {
        $post = Post::find($post);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully', $post]);
    }
}
