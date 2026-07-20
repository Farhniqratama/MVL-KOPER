<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use Carbon\Carbon;

class CancelOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel orders older than one day that are still pending';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $canceledOrders = Transaksi::where('status', 0)
            ->where('metode_pembayaran', '!=', 3)
            ->where('created_at', '<=', Carbon::now()->subDay())
            ->update(['status' => 5]);

        $this->info("Canceled $canceledOrders orders.");
        return 0;
    }
}
