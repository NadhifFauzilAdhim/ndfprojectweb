<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Linkvisithistory;
use Carbon\Carbon;

class CleanupOldVisitHistory implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        Linkvisithistory::where('created_at', '<', $oneMonthAgo)->delete();
    }
}