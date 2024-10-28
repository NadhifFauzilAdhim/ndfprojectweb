<?php

namespace App\Http\Controllers;
use App\Models\Link;
use App\Models\Linkvisithistory;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function __invoke(Link $link)
    {
        if (!$link->active) {
            return view('redirect.inactive', [
                'title' => "Link Inactive",
                'message' => 'Link Inactive',
            ]);
        }

        $sessionKey = 'visited_link_' . $link->id;
        
        if (!session()->has($sessionKey)) {
            Linkvisithistory::create([
                'link_id' => $link->id,
                'status' => true,
            ]);
            $link->increment('visits');
            session([$sessionKey => true]);
        }
        
        return view('redirect.redirecting', ['targetUrl' => $link->target_url]);
    }


    
}
