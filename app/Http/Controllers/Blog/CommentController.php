<?php

namespace App\Http\Controllers\Blog;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\FuncCall;

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

    public function reply(Request $request, Comment $comment){

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);
        $comment->commentreplies()->create([
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);
        return back()->with('success', 'Comment posted!');
    }

    public function destroyReply(CommentReply $reply)
    {
        if (Auth::id() !== $reply->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }
        $reply->delete();
        return back()->with('success', 'Comment deleted!');
    }


}
