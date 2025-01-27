<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Linkvisithistory;
use App\Models\BlockedIp; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    public function __invoke(Request $request, Link $link)
    {
        return redirect('http://linksy.test/' . $link->slug);

        if (!$link->active) {
            return view('redirect.inactive', [
                'title' => "Link Inactive",
                'message' => 'Link Inactive',
            ]);
        }

        $ipAddress = $request->ip();
        $blockedIp = BlockedIp::where('link_id', $link->id)
            ->where('ip_address', $ipAddress)
            ->exists();
            
        $userAgent = $request->header('User-Agent');
        $refererUrl = $request->header('Referer');
        $location = $this->getLocationFromIp($ipAddress);

        if ($blockedIp) {
            abort(403, 'Access forbidden');
        }

        if ($link->password_protected) {
            $password = $request->input('password');
            if (!$password) {
                return view('redirect.passwordreq', [
                    'title' => "Password Protected",
                    'message' => 'This link is password protected.',
                    'linkSlug' => $link->slug,
                ]);
            }
            if (!Hash::check($password, $link->password)) {
                $this->recordVisit($link, false, $ipAddress, $userAgent, $refererUrl, $location, $request);
                return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
            }
        }

        $this->recordVisit($link, true, $ipAddress, $userAgent, $refererUrl, $location, $request);

        return view('redirect.redirecting', [
            'targetUrl' => $link->target_url,
            'title' => $link->title
        ]);
    }

    private function getLocationFromIp($ip)
    {
        try {
            $response = file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);
            if ($data['status'] === 'success') {
                return "{$data['city']}, {$data['country']}";
            }
        } catch (\Exception) {
            return 'Uknown Location';
        }
        return 'Unknown Location';
    }

    private function recordVisit($link, $status, $ipAddress, $userAgent, $refererUrl, $location, $request)
    {
        $sessionKey = "visited_link_{$link->slug}";
        $hasVisited = $request->session()->has($sessionKey);
        $isUniqueByIP = !Linkvisithistory::where('link_id', $link->id)
            ->where('ip_address', $ipAddress)
            ->exists();
    
        if (!$hasVisited && $isUniqueByIP) {
            $request->session()->put($sessionKey, true);
            Linkvisithistory::create([
                'link_id' => $link->id,
                'status' => $status,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'referer_url' => $refererUrl ?? 'Direct',
                'location' => $location,
                'is_unique' => true,
            ]);
    
            $link->increment('unique_visits');
        } else {
            Linkvisithistory::create([
                'link_id' => $link->id,
                'status' => $status,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'referer_url' => $refererUrl,
                'location' => $location,
                'is_unique' => false,
            ]);
        }
        $link->increment('visits');
    }
    
}
