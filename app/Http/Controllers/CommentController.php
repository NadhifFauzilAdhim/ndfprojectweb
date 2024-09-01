<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
   
    public function store(Request $request,Post $post)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'body' => $request->message,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Comment posted!');

    }
    public function destroy(Comment $comment)
    {

        if (Auth::id() !== $comment->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted!');
    }
}
