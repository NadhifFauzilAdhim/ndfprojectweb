<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $posts = Post::latest()->get();
        return PostResource::collection($posts);
    }


    public function showBySlug($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], Response::HTTP_NOT_FOUND);
        }

       return new PostResource($post);
    }


}
