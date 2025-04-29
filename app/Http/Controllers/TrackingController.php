<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.tracking.index', [
            'title' => 'Tracking',
            'trackings' => Tracking::where('user_id', Auth::id()) 
                ->with([
                    'trackingHistories' => function($query) {
                        $query->latest()->limit(3);
                    }
                ])
                ->withCount([
                    'trackingHistories as unique_visits' => function($query) {
                        $query->where('is_unique', true);
                    }
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(20)
        ]);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'target_url' => 'required|url',
        ]);

        do {
            $slug = Str::random(5);
        } while (Tracking::where('slug', $slug)->exists()); 
    
        $validatedData['slug'] = $slug; 
        $validatedData['target_url'] = filter_var($validatedData['target_url'], FILTER_SANITIZE_URL);
        $validatedData['user_id'] = Auth::id();
        Tracking::create($validatedData);
        return redirect()->route('dashboard.tracking.index')->with('success', 'Tracking created successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tracking $tracking)
    {
        $tracking->delete();
        return redirect()->route('dashboard.tracking.index')->with('success', 'Tracking deleted successfully.');
    }
}
