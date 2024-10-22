<?php

namespace App\Http\Controllers;
use App\Models\Link;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke($slug)
    {
        $link = Link::where('slug', $slug)->first();
        if (!$link) {
            return view('redirect.inactive', [
                'title' => "Invalid Link",
            ]);
        }
        $link->increment('visits');
        return redirect($link->target_url);
    }
}
