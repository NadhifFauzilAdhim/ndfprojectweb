<?php

namespace App\Http\Controllers;

use App\Models\BlockedIp;
use Illuminate\Http\Request;

class BlockedIpController extends Controller
{
    
    public function block(Request $request)
    {
        $request->validate([
            'ip_address' => 'required|ip', 
            'link_id' => 'required|exists:links,id',
        ]);
        BlockedIp::create([
            'ip_address' => $request->ip_address,
            'link_id' => $request->link_id, // Tambahkan link_id di sini
        ]);
        return back()->with('success', 'IP Address blocked successfully.');
    }
    public function unblock($id)
    {
        BlockedIp::findOrFail($id)->delete();
        return back()->with('success', 'IP Address unblocked successfully.');
    }
}
