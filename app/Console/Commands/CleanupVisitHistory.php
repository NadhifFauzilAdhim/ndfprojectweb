<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Linkvisithistory;
use Carbon\Carbon;

class CleanupVisitHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visit-history:cleanup';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Cleanup visit history records older than 1 month based on created_at';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Hitung tanggal 1 bulan yang lalu
        $oneMonthAgo = Carbon::now()->subMonth();

        // Hapus record yang lebih tua dari 1 bulan
        $deletedRows = Linkvisithistory::where('created_at', '<', $oneMonthAgo)->delete();

        $this->info("Deleted {$deletedRows} visit history records older than 1 month.");
    }
}