<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.post', [
            'title' => 'Create Post',
            'posts' => Post::where('author_id', Auth::id())->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.createpost', [
            'title' => 'Create Post',
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ]);
        if($request->file('image')){     
            $validatedData['image']=$request->file('image')->store('post-image');
        }

        $validatedData['author_id'] = Auth::id();
       
        Post::create($validatedData);
        return redirect('/dashboard/posts')->with('success','Post Berhasil Dibuat');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.singlepost',[
            'title'=> 'Detail Post',
            'post'=> $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.editpost',[
            'title'=>'Edit Post',
            'post'=> $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $datarules =([
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ]);
        if($request->slug != $post->slug){
            $datarules['slug'] = 'required|unique:posts';
        }
        $validatedData = $request->validate($datarules);
        if($request->file('image')){
            if($request->oldImagePoster){
                Storage::delete($request->oldImagePoster);
            }
        $validatedData['image']=$request->file('image')->store('post-images');
        }
        $validatedData['author_id'] = Auth::id();
       
        Post::where('id', $post->id)
            ->update($validatedData);
        return redirect('/dashboard/posts')->with('success','Post Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->image){
            Storage::delete($post->image);
        }
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success','Post Dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class,'slug', $request->title);
        return response()->json(['slug'=>$slug]);
    }
}
