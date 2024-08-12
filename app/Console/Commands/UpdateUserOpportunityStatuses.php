<?php

namespace App\Console\Commands;

use App\Models\OpportunityData;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateUserOpportunityStatuses extends Command
{
    protected $signature = 'user-opportunity-status:update';
    protected $description = 'Update the statuses in user_opportunity_statuses based on conditions from opportunity_data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        // Update status from 5 to 6 where date_from has passed
        DB::table('user_opportunity_statuses')
            ->join('opportunity_data', 'user_opportunity_statuses.opportunity_id', '=', 'opportunity_data.id')
            ->where('user_opportunity_statuses.status', 5)
            ->where('opportunity_data.date_from', '<', $now)
            ->update(['user_opportunity_statuses.status' => 6]);

        // Update status from 6 to 7 where date_to has passed
        DB::table('user_opportunity_statuses')
            ->join('opportunity_data', 'user_opportunity_statuses.opportunity_id', '=', 'opportunity_data.id')
            ->where('user_opportunity_statuses.status', 6)
            ->where('opportunity_data.date_to', '<', $now)
            ->update(['user_opportunity_statuses.status' => 7]);

        OpportunityData::where('deadline_apply', '<', $now)
            ->where('status_id', '!=', 2)
            ->update(['status_id' => 2]);

        $this->info('User opportunity statuses updated successfully.');
    }
}
