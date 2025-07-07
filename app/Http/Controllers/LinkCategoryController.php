<?php

namespace App\Http\Controllers;
use App\Models\LinkCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class LinkCategoryController extends Controller
{
    
    /**
     * Store a newly created link category in storage.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
    
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique('link_categories')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }),
            ],
        ]);
    
        $baseSlug = Str::slug($validated['name']);
        $randomChars = Str::lower(Str::random(6));
    
        $category = LinkCategory::create([
            'user_id' => $userId,
            'name' => $validated['name'],
            'slug' => "{$baseSlug}-{$randomChars}",
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan!',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug, 
            ]
        ], 201);
    }
    public function toggleShare(LinkCategory $category): JsonResponse
    {
        if ($category->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        $category->shared = !$category->shared;
        $category->save();

        $newStatus = $category->shared ? 'shared' : 'private';
        return response()->json([
            'success' => true,
            'message' => "Category is now {$newStatus}.",
            'shared' => $category->shared,
        ]);
    }

    public function destroy(LinkCategory $category)
    {
        if ($category->user_id !== Auth::id()) {
            return redirect()->route('link.index')->with('error', 'Unauthorized action.');
        }

        $category->delete();
        return redirect()->route('link.index')->with('success', 'Kategori berhasil dihapus!');
    }
    
}
