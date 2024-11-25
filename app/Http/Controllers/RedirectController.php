<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Linkvisithistory;
use App\Models\BlockedIp; // Pastikan sudah ada model BlockedIp
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    public function __invoke(Request $request, Link $link)
    {
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
                $this->recordVisit($link,false, $ipAddress, $userAgent, $refererUrl, $location);
                return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
            }
        }
        $this->recordVisit($link,true, $ipAddress, $userAgent, $refererUrl, $location);

        return view('redirect.redirecting', ['targetUrl' => $link->target_url]);
    }

    private function getLocationFromIp($ip)
    {
        try {
            $response = file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);
            if ($data['status'] === 'success') {
                return "{$data['city']}, {$data['country']}";
            }
        } catch (\Exception $e) {
            return 'Unknown Location';
        }
        return 'Unknown Location';
    }

    private function recordVisit($link, $status, $ipAddress, $userAgent, $refererUrl, $location)
    {
        $isUnique = !Linkvisithistory::where('link_id', $link->id)
            ->where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->exists();

        Linkvisithistory::create([
            'link_id' => $link->id,
            'status' => $status,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'referer_url' => $refererUrl,
            'location' => $location,
            'is_unique' => $isUnique,
        ]);

        if ($isUnique) {
            $link->increment('unique_visits');
        }

        $link->increment('visits');
    }
}
