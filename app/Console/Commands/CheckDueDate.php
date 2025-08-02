<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pastor;
use Carbon\Carbon;

class CheckDueDate extends Command
{
    protected $signature = 'pastors:update-status';
    protected $description = 'Update pastor status to "transfer due" if to_date has passed';

    public function handle()
    {
        $today = Carbon::today();

        $pastors = Pastor::whereDate('to_date', '<=', $today)
            ->where('status', '!=', 'transfer due')
            ->get();

        foreach ($pastors as $pastor) {
            $pastor->status = 'transfer due';
            $pastor->save();

            $this->info("Updated pastor {$pastor->pastor_code} to 'transfer due'");
        }

        return 0;
    }
}

