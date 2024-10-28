<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Linkvisithistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = Link::where('user_id', Auth::id())->latest()->paginate(6);
        $visits = Linkvisithistory::whereHas('link', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();
        $visitData = [];
        foreach (range(1, 7) as $day) {
            $visitData[$day] = $visits->firstWhere('day', $day)->total_visits ?? 0;
        }
        return view('dashboard.shortlink.index', [
            'title' => 'Short Link',
            'links' => $links,
            'visitData' => array_values($visitData), 
        ]);
    }

    public function show(Link $link){
        if ($link->user_id !== Auth::id()) {
            abort(404);
        }
        return view('dashboard.shortlink.linkdetail', [
            'title' => 'Detail Link',
            'link' => $link,
            'visithistory' => Linkvisithistory::where('link_id', $link->id)->latest()->paginate(3)
        ]);
    }

    public function update(Request $request, Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }
        if($request->target_url != $link->target_url){
            $validatedData = $request->validate([
                'target_url' => 'required|max:255|url',
            ]);
            $validatedData['target_url'] = filter_var($validatedData['target_url'], FILTER_SANITIZE_URL);
        }
        
        $validatedData['active'] = $request->has('active') ? 1 : 0;
        $link->update($validatedData);
        return redirect()->back()->with('success', 'Link Berhasil Diubah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'target_url' => 'required|max:255|url', 
            'slug' => 'required|max:255|unique:links'
        ]);
        $validatedData['target_url'] = filter_var($validatedData['target_url'], FILTER_SANITIZE_URL);
        $validatedData['user_id'] = Auth::id();
        Link::create($validatedData);
        return redirect()->back()->with('success', 'Link Berhasil Ditambahkan');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }
        Link::destroy($link->id);
        return redirect()->back()->with('success', 'Link Berhasil Dihapus');
    }

}
