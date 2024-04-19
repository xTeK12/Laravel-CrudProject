<?php

namespace App\Jobs\Orders;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_details;
use App\Services\Constants;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PlaceOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param int $user_id
     * @param mixed $request
     */
    public function __construct(private int $user_id, private mixed $request)
    {
        $this->queue = 'orders';
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $cartProducts = Cart::query()->where('user_id', $this->user_id)->get();

        if($cartProducts->isNotEmpty()) {
            $newOrder = new Order();
            $newOrder->user_id = $this->user_id;
            $newOrder->save();
            foreach ($cartProducts as $cartProduct) {
                $newOrderDetails = new Order_details();
                $newOrderDetails->order_id = $newOrder->id;
                $newOrderDetails->product_id = $cartProduct->product_id;
                $newOrderDetails->adress = $this->request['adress'];
                $newOrderDetails->payment = $this->request['payment'];
                $newOrderDetails->quantity = $cartProduct->quantity;
                $newOrderDetails->save();
            }

            Cart::query()->where('user_id', $this->user_id)->delete();
        }
    }
}
