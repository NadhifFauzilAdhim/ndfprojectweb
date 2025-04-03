<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PostDeleted;
use Illuminate\Support\Facades\Notification;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $posts = Post::query()
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%");  // Adjust fields as necessary
            })
            ->latest()->paginate(10);

        return view('dashboard.adminpost', [
            'title' => 'Post Management',
            'posts' => $posts
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Request $request)
    { 

        $request->validate([
            'delete_reason' => 'required|max:100',
        ]);

        if($post->image){
            Storage::delete($post->image);
        }
        if($post->author->is_owner){
            return redirect()->back()->with('error', 'You cannot delete this post. FORBIDDEN');
        }
        // Notification::send($post->author, new PostDeleted($request->delete_reason, $post->title));
        Post::destroy($post->id);
        return redirect()->back()->with('success', 'Post Dihapus');
    }
}
