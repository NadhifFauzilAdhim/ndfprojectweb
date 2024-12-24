<?php

namespace App\Http\Controllers\Api;

use App\Models\BlockedIp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class ApiBlockIpsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */

     public function show(int $link_id)
     {
         try {
             $blockedIps = BlockedIp::where('link_id', $link_id)->get();
             if ($blockedIps->isEmpty()) {
                 return response()->json([
                     'success' => true,
                     'message' => 'No blocked IPs found for the given link ID.',
                     'data' => [],
                 ], 200);
             }
             return response()->json([
                 'success' => true,
                 'message' => 'Blocked IPs retrieved successfully.',
                 'data' => $blockedIps,
             ], 200);
     
         } catch (\Exception $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'An unexpected error occurred.',
                 'error' => $e->getMessage(),
             ], 500);
         }
     }
     

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ip_address' => 'required|ip|unique:blocked_ips,ip_address',
                'link_id' => 'required|exists:links,id',
            ]);

            $blockedIp = BlockedIp::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'IP Address blocked successfully.',
                'data' => $blockedIp,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422); 
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage(),
            ], 500); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $blockedIp = BlockedIp::findOrFail($id);
            $blockedIp->delete();

            return response()->json([
                'success' => true,
                'message' => 'IP Address unblocked successfully.',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }
}
