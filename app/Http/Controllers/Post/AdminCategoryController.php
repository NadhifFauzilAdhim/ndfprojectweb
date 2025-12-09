<?php

namespace App\Http\Controllers\Post;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('admin');
        return view('dashboard.admincategories', [
            'title' => 'Categories',
            'categories' => Category::all()
        ]);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories',
            'image' => 'required|url'
        ]);
        
        Category::create($validatedData);
        return redirect('/dashboard/categories')->with('success', 'Category berhasil ditambahkan');
    }

    
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|max:255',
            'image' => 'required|url'
        ];
        if ($request->slug != $category->slug) {
            $rules['slug'] = 'required|unique:categories';
        }
        $validatedData = $request->validate($rules);
        $category->update($validatedData);
        return redirect('/dashboard/categories')->with('success', 'Category Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
    if ($category->posts()->exists()) {
        return redirect('/dashboard/categories')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki postingan.');
    }

    $category->delete();

    return redirect('/dashboard/categories')->with('success', 'Kategori berhasil dihapus.');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
