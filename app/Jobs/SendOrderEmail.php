<?php

namespace App\Jobs;

use App\Mail\SaveSalesOrder;
use App\Models\SalesOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $salesOrder;

    /**
     * Create a new job instance.
     */
    public function __construct(SalesOrder $salesOrder)
    {
        $this->salesOrder = $salesOrder;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $salesOrder = $this->salesOrder;
        $salesOrder->load('customer', 'user');
        $salesOrder->setAttribute('inventory', $salesOrder->getInventoyAttribute());
        $salesOrder->setAttribute('payment_amount', $salesOrder->getTotalPaymentAmountAttribute());
        $email = $salesOrder['customer']['email'];
        Mail::to($email)->send(new SaveSalesOrder($salesOrder));
    }
}
