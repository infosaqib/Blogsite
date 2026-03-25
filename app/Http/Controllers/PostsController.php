<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;

class PostsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/posts",
     *     summary="List all posts",
     *     tags={"Posts"},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        return  $posts;
    }

    /**
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Get a post by ID",
     *     tags={"Posts"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Success"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show($post)
    {
        $posts = Post::find($post);
        return $posts;
    }

    /**
     * @OA\Get(
     *     path="/posts/search",
     *     summary="Search posts",
     *     tags={"Posts"},
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function searchPosts()
    {
        $post = Post::where('id', 1)->get();
        return $post;
    }

    /**
     * @OA\Post(
     *     path="/posts",
     *     summary="Create a new post",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","body","userId"},
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="body", type="string"),
     *             @OA\Property(property="userId", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Created"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(CreatePostRequest $request)
    {
        $data = $request->only(['title', 'body', 'userId']);
        $data['title'] = trim($data['title']);
        $post = Post::create($data);
        return $post;
    }

    /**
     * @OA\Put(
     *     path="/posts/{id}",
     *     summary="Update a post",
     *     tags={"Posts"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="body", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Updated"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function update(UpdatePostRequest $request, $post)
    {
        $data = $request->only(['title', 'body']);
        $post = Post::find($post);
        $post->update($data);
        return $post;
    }

    /**
     * @OA\Delete(
     *     path="/posts/{id}",
     *     summary="Delete a post",
     *     tags={"Posts"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function destroy($post)
    {
        $post = Post::find($post);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully', $post]);
    }
}
