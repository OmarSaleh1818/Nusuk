<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Partnerships;
use Carbon\Carbon;

class UpdateExpiredPartnerships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'partnerships:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the partnership status if the end_date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date
        $today = Carbon::now();

        // Find partnerships where the end_date is in the past and the status hasn't been updated yet
        $expiredPartnerships = Partnerships::where('end_date', '<', $today)
                                            ->where('partnership_status', '!=', 'Expired') // Assuming 'Expired' is the status
                                            ->get();

        // Update the status of each expired partnership
        foreach ($expiredPartnerships as $partnership) {
            $partnership->update([
                'partnership_status' => 'Expired', // Set the status to 'Expired'
                'updated_at' => Carbon::now(), // Update the timestamp
            ]);
        }

        // Output a message to the console
        $this->info('Expired partnerships have been updated.');
    }
}
