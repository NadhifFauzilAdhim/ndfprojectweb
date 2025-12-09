<?php

namespace App\Http\Controllers\LinkManagement;
use App\Http\Controllers\Controller;
use App\Models\BlockedIp;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BlockedIpController extends Controller
{
    
    public function block(Request $request)
    {
        try {
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
            ], 200);
    
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422); 
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }
    
    public function unblock($id)
    {

    

        $blockedIp = BlockedIp::findOrFail($id);
        if($blockedIp){
            $blockedIp->delete();
            return response()->json([
                'success' => 'IP Address unblocked successfully.',
            ]);
        }
        else{
            return response()->json([
                 'error' => 'Error Unblocking IPs'
            ]);
        }
    }
    
}
