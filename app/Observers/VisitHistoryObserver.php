<?php

namespace App\Observers;

use App\Models\Linkvisithistory;
use Carbon\Carbon;
use App\Jobs\CleanupOldVisitHistory;

class VisitHistoryObserver
{
    /**
     * Handle the Linkvisithistory "created" event.
     */
    public function created(Linkvisithistory $linkvisithistory)
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        Linkvisithistory::where('created_at', '<', $oneMonthAgo)
        ->limit(100) 
        ->delete();
    }

    /**
     * Handle the Linkvisithistory "updated" event.
     */
    public function updated(Linkvisithistory $linkvisithistory)
    {
    }

    /**
     * Handle the Linkvisithistory "deleted" event.
     */
    public function deleted(Linkvisithistory $linkvisithistory)
    {
    }

    /**
     * Handle the Linkvisithistory "restored" event.
     */
    public function restored(Linkvisithistory $linkvisithistory)
    {
    }

    /**
     * Handle the Linkvisithistory "forceDeleted" event.
     */
    public function forceDeleted(Linkvisithistory $linkvisithistory)
    {
    }
}