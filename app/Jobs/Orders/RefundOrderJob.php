<?php

namespace App\Jobs\Orders;

use App\Models\Order;
use App\Models\Order_details;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RefundOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private int $orderId;

    /**
     * @param $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
        $this->queue = 'refunds';
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $order = Order::where('id', $this->orderId)->first();
        foreach ($order->orderDetails as $orderDetail)
        {
            $quantityRefund = $orderDetail->quantity;
            $product = Product::find($orderDetail->product_id);
            if($product)
            {
                $product->quantity += $quantityRefund;
                $product->save();
            }
            if($orderDetail->delete()){
                Log::info('Order deleted with ID {orderId}', ['orderId' => $this->orderId]);
            }

        }
        $order->delete();
    }
}
