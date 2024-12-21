<?php

namespace App\Http\Controllers;
use App\Models\BlockedIp;
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
    public function index(Request $request)
    {
        $totalLinks = Link::where('user_id', Auth::id())->count();
        $totalVisit = Link::where('user_id', Auth::id())->sum('visits');
        $totalUniqueVisit = Link::where('user_id', Auth::id())->sum('unique_visits');
        $search = $request->input('search');
        $links = Link::where('user_id', Auth::id())->when($search, function ($query, $search) { return $query->where('slug', 'like', "%{$search}%"); })->latest()->paginate(6);
        $topLink = Link::where('user_id',Auth::id())->orderByDesc('visits')->take(4)->get();
        $visits = Linkvisithistory::whereHas('link', function ($query) {
                $query->where('user_id', Auth::id());
            })->select(DB::raw('DAYOFWEEK(created_at) as day'), DB::raw('COUNT(*) as total_visits'))
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
            'totalLinks' => $totalLinks,
            'totalVisit' => $totalVisit,
            'totalUniqueVisit' => $totalUniqueVisit,
            'topLinks' => $topLink
        ]);
    }
    public function show(Link $link, Request $request)
    {
        if ($link->user_id !== Auth::id()) {
            abort(403);
        }
        $filter = $request->query('filter', 'all');
        $query = Linkvisithistory::where('link_id', $link->id);
        if ($filter === 'unique') {
            $query->where('is_unique', true);
        }elseif($filter === 'redirected'){
            $query->where('status', 1);
        }elseif($filter === 'rejected'){
            $query->where('status', 0);
        }
        $visithistory = $query->latest()->paginate(10);
        $redirectedCount = Linkvisithistory::where('link_id', $link->id)->where('status', 1)->count();
        $rejectedCount = Linkvisithistory::where('link_id', $link->id)->where('status', 0)->count();
        $blockedIps = BlockedIp::where('link_id', $link->id)->get();
        $topReferers = Linkvisithistory::where('link_id', $link->id)
        ->select('referer_url', DB::raw('COUNT(*) as visit_count'))
        ->groupBy('referer_url')
        ->orderByDesc('visit_count')
        ->limit(5) 
        ->get();
        
        $visitsByDay = Linkvisithistory::where('link_id', $link->id)
        ->whereDate('created_at', '>=', now()->subDays(7)) 
        ->selectRaw('DAYOFWEEK(created_at) as day, COUNT(*) as count')
        ->groupBy('day')
        ->pluck('count', 'day')
        ->toArray();
        $chartData = [];
        for ($i = 1; $i <= 7; $i++) {
            $chartData[] = $visitsByDay[$i] ?? 0; 
        }

        return view('dashboard.shortlink.linkdetail', [
            'title' => 'Detail Link',
            'link' => $link,
            'visithistory' => $visithistory,
            'redirectedCount' => $redirectedCount,
            'rejectedCount' => $rejectedCount,
            'blockedIps' => $blockedIps,
            'filter' => $filter,
            'chartData' => $chartData,
            'topReferers' => $topReferers,
        ]);
    }
    public function update(Request $request, Link $link)
    {
        if ($link->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $validatedData = $request->validate([
            'target_url' => 'required|max:255|url',
            'slug' => 'required|max:255|unique:links,slug,' . $link->id,
            'password' => 'nullable|min:6|max:255',
        ]);
    
        $oldSlug = $link->slug;
        $validatedData['target_url'] = filter_var($validatedData['target_url'], FILTER_SANITIZE_URL);
        $validatedData['password_protected'] = $request->has('password_protected') ? 1 : 0;
        $validatedData['password'] = $validatedData['password_protected']
            ? (!empty($request->password) ? bcrypt($request->password) : $link->password)
            : null;
        $validatedData['active'] = $request->has('active') ? 1 : 0;
        $link->update($validatedData);
        if ($oldSlug !== $link->slug) {
            return response()->json([
                'success' => true,
                'message' => 'Slug updated successfully! Link updated.',
                'redirect' => route('link.show', ['link' => $link->slug]),
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Link updated successfully!',
        ]);
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
