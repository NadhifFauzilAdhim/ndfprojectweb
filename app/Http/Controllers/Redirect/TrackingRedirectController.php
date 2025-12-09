<?php

namespace App\Http\Controllers\Redirect;
use App\Http\Controllers\Controller;
use App\Models\TrackingHistory;
use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingRedirectController extends Controller
{


    public function __invoke(Request $request, Tracking $tracking)
    {
        return view('tracking.redirect', [
            'title' => 'Tracking Redirect',
            'tracking' => $tracking,
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TrackingHistory $trackingHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrackingHistory $trackingHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrackingHistory $trackingHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrackingHistory $trackingHistory)
    {
        //
    }
}
