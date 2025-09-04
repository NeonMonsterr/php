<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;

class UpdateSubscriptionsStatus extends Command
{
    protected $signature = 'subscriptions:update-status';
    protected $description = 'Update subscription status to expired if end_date is in the past';

    public function handle()
    {
        try {
            $updated = Subscription::where('status', '!=', 'canceled')
                ->whereNotNull('end_date')
                ->where('end_date', '<', now())
                ->update(['status' => 'expired']);
            $this->info("Updated $updated subscriptions to expired status.");
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            \Log::error('Subscription status update failed: ' . $e->getMessage());
        }
    }
}
