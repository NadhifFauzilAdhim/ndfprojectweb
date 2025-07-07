<?php

namespace App\Http\Controllers;

use App\Models\Linkvisithistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanupController extends Controller
{
    /**
     * Membersihkan data riwayat kunjungan (visit history) yang lebih tua dari 30 hari.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cleanupOldVisits()
    {
        try {
            $cutoffDate = Carbon::now()->subDays(30);
            $query = Linkvisithistory::where('created_at', '<', $cutoffDate);
            $count = $query->count();

            if ($count > 0) {
                $query->delete();
                $message = "Successfully deleted {$count} visit history records older than 30 days.";
                Log::info($message);
            } else {
                $message = "No old visit history records to delete.";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'deleted_records' => $count,
            ]);

        } catch (\Exception $e) {
            Log::error("Error during visit history cleanup: " . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred during the cleanup process.',
            ], 500);
        }
    }
}