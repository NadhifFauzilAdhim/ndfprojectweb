<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home',[
            'title' => 'Home',
            'posts' => Post::select(['id', 'title', 'author_id', 'category_id', 'excerpt', 'slug', 'image', 'created_at', 'updated_at','views'])
                ->filter(request(['search', 'category', 'author']))
                ->where('is_published', true)
                ->take(6)
                ->latest()
                ->get()
        ]);
    }


    public function beloved(){
        return view('hidden',[
            'title' => 'Beloved',
        ]);
    }

    public function blog()
    {
        $baseQuery = Post::select(['id', 'title', 'author_id', 'category_id', 'excerpt', 'slug', 'image', 'created_at', 'updated_at','views'])
            ->filter(request(['search', 'category', 'author']))
            ->where('is_published', true);
        $posts = (clone $baseQuery)
            ->latest()
            ->paginate(6)
            ->withQueryString();
        $topPosts = (clone $baseQuery)
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();
    
        return view('blog', [
            'title' => 'Blog',
            'type' => 'all',
            'posts' => $posts,
            'topPosts' => $topPosts
        ]);
    }

    public function showPost(Post $post)
    {
        if(!$post->is_published && $post->author_id !== Auth::id()) {
            abort(404);
        }
        $post->increment('views');
        // Eager load relationships and order comments
        $post->load([
            'author', 
            'category',
            'comments.user', 
            'comments.commentreplies.user',
            'comments' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            
        ]);

        return view('post', [
            'title' => $post->title,
            'post' => $post
        ]);
    }    

    public function showAuthor(User $user)
    {
        return view('blog', [
            'title' => 'Article By ' . $user->name,
            'type' => 'author',
            'posts' => $user->posts->only(['id', 'title', 'slug', 'excerpt', 'image', 'created_at', 'updated_at'])
        ]);
    }

    public function showCategory(Category $category)
    {
        return view('blog', [
            'title' => 'Category ' . $category->name,
            'type' => 'category',
            'posts' => $category->posts->only(['id', 'title', 'slug', 'excerpt', 'image', 'created_at', 'updated_at'])
        ]);
    }

    public function arabisindex(){
        return view('arabis.index',[
            'title' => 'Arabis Group',
            'posts' => Post::filter(request(['search', 'category', 'author']))->where('is_published', true)->latest()->paginate(6)->withQueryString()
        ]);
    }

    public function ipdocuments(){
        return view('ipdocument',[
            'title' => 'IP Documents',
            'posts' => Post::filter(request(['search', 'category', 'author']))->where('is_published', true)->latest()->paginate(6)->withQueryString()
        ]);
    }

    public function download(){
        return redirect(url('/download/PORTOFOLIO.pdf'));
    }


}

