<?php

namespace App\Http\Controllers;

use App\Models\BlockedIp;
use Illuminate\Http\Request;

class BlockedIpController extends Controller
{
    
    public function block(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip',
            'link_id' => 'required|exists:links,id',
        ]);
    
        $blockedIp = BlockedIp::create([
            'ip_address' => $validated['ip_address'],
            'link_id' => $validated['link_id'],
        ]);
    
        return response()->json([
            'success' => 'IP Address blocked successfully.',
            'blockedIp' => $blockedIp,
        ]);
    }
    
    public function unblock($id)
    {
        $blockedIp = BlockedIp::findOrFail($id);
        $blockedIp->delete();
    
        return response()->json([
            'success' => 'IP Address unblocked successfully.',
        ]);
    }
    
}
