<?php

namespace App\Console\Commands;

use App\Models\EmployeeLocation;
use Illuminate\Console\Command;

class PruneLocationHistory extends Command
{
    protected $signature   = 'locations:prune';
    protected $description = 'Delete employee location records older than 7 days';

    public function handle(): void
    {
        $deleted = EmployeeLocation::where('recorded_at', '<', now()->subDays(7))->delete();
        $this->info("Pruned {$deleted} old location records.");
    }
}
