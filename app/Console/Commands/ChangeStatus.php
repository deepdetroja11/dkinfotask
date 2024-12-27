<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChangeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stock:update-status';
    // php artisan stock:update-status

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the stock status of inventory items based on the in_stock_date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();

        $updatedCount = Stock::where('in_stock_date', $today)
            ->where('stock_status', '!=', 'in_stock')
            ->update(['stock_status' => 'in_stock']);

        if ($updatedCount > 0) {
            $this->info("Stock status updated to 'in_stock' for {$updatedCount} items.");
        } else {
            $this->info("No items found with today's date ({$today}) in in_stock_date.");
        }

        return Command::SUCCESS;
    }
}
