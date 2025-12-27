<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Gemini\Laravel\Facades\Gemini;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        return view('dashboard.post', [
            'title' => 'Create Post',
            'posts' => Post::select(['id', 'title','is_published', 'author_id', 'category_id', 'excerpt', 'slug', 'image', 'created_at', 'updated_at'])->where('author_id', Auth::id())
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%");
            })
            ->latest()->paginate(6)
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
            'is_published' => 'required|boolean',
            'image' => 'image|file|max:2048',
            'body' => 'required'
        ]);
    
        $validatedData['author_id'] = Auth::id(); // Tetapkan author_id terlebih dahulu
        $validatedData['excerpt'] = str()->limit(trim(preg_replace('/\s+/', ' ', strip_tags($request->body))), 100);
    
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                // Proses file gambar
                $file = $request->file('image');
                $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = base_path('../public/post-image');
    
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
    
                $tempPath = $file->move($destinationPath, $imageName);
    
                $fullPath = $destinationPath . '/' . $imageName;
    
                $imgManager = new ImageManager(new Driver);
                $filteredImage = $imgManager->read($fullPath);
                $filteredImage->resize(600, 315)->save($fullPath);
    
                $validatedData['image'] = 'post-image/' . $imageName;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error processing image: ' . $e->getMessage());
            }
        }
    
        // Simpan data post
        Post::create($validatedData);
        return redirect('/dashboard/posts')->with('success', 'Post Berhasil Dibuat');
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
        $datarules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'nullable|image|file|max:2048', // Gambar opsional
            'body' => 'required',
        ];
    
        if ($request->slug != $post->slug) {
            $datarules['slug'] = 'required|unique:posts';
        }
    
        $validatedData = $request->validate($datarules);
    
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            try {
                if ($post->image && file_exists(base_path('../public/' . $post->image))) {
                    unlink(base_path('../public/' . $post->image));
                }
    
                $file = $request->file('image');
                $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = base_path('../public/post-image');
    
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
    
                $file->move($destinationPath, $imageName);
                $fullPath = $destinationPath . '/' . $imageName;
                $imgManager = new ImageManager(new Driver);
                $filteredImage = $imgManager->read($fullPath);
                $filteredImage->resize(600, 315)->save($fullPath);
    
                $validatedData['image'] = 'post-image/' . $imageName;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error processing image: ' . $e->getMessage());
            }
        }
    
        $validatedData['author_id'] = Auth::id();
        $validatedData['excerpt'] = str()->limit(trim(preg_replace('/\s+/', ' ', strip_tags($request->body))), 100);
        $post->update($validatedData);
    
        return redirect('/dashboard/posts')->with('success', 'Post Berhasil Diubah');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            if ($post->image && file_exists(base_path('../public/' . $post->image))) {
                unlink(base_path('../public/' . $post->image));
            }
            $post->delete();
    
            return redirect('/dashboard/posts')->with('success', 'Post berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus post: ' . $e->getMessage());
        }
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class,'slug', $request->title);
        return response()->json(['slug'=>$slug]);
    }

     public function generatePost(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'language' => 'required|in:id,en',
        ]);
        $title = $request->input('title');
        $language = $request->input('language');
        $model = 'gemini-2.0-flash';
    
        try {
            $prompt = "Write a well-structured article about '$title' in '$language'. 
            The article should include:
            - A clear and informative title using <h1>.
            - Well-organized paragraphs using <p>.
            - Proper structure with an introduction, main content, and conclusion.
            - Avoid unnecessary tags.";
            $result = Gemini::generativeModel($model)->generateContent($prompt);
            
            $generatedContent = $result->text();
    
            return response()->json([
                'success' => true,
                'title' => $title,
                'body' => $generatedContent,
            ], 200, ['Content-Type' => 'application/json']);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating post: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function visibility(Post $post , Request $request)
    {
       $validatedData = $request->validate([
           'is_published' => 'required|boolean'
       ]);
       if($post->is_published != $validatedData['is_published']){
           $post->update($validatedData);
           return redirect()->back()->with('success','Visibility Diubah');
       }
       return redirect()->back()->with('error','Post Tidak Berubah');
    }
}
