<?php

namespace App\Http\Controllers;
use App\Models\Link;
use App\Models\Linkvisithistory;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke($slug)
    {
        $link = Link::where('slug', $slug)->first();

        if (!$link) {
            return view('redirect.notfound', [
                'title' => "Link Not Found",
                'message' => 'Link Not Found',
            ], 404);
        }
        if (!$link || !$link->active) {
            return view('redirect.inactive', [
                'title' => "Link Inactive",
                'message' => 'Link Inactive',
            ]);
        }
        Linkvisithistory::create([
            'link_id' => $link->id,
            'status' => true,
        ]);
        $link->increment('visits');
        return redirect($link->target_url);
    }


}
