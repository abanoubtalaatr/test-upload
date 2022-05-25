<?php

namespace App\Infrastructure\Console\Commands;

use App\Order\Domain\Models\Order;
use Illuminate\Console\Command;

class RemoveFailedPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:failedpayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for remove failed payments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Remove Failed Payments
        $orders=Order::withoutGlobalScopes()->where('is_paid',0)
            ->where('created_at','<',now()->subDays(2))->delete();
    }

}
