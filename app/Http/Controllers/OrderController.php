<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Jobs\Orders\PlaceOrderJob;
use App\Jobs\Orders\RefundOrderJob;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

;

class OrderController extends Controller
{
    /**
     * @param $userId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index($userId)
    {
        $userOrders = Order::query()->where('user_id', $userId)->get();

        return view('orders.index', compact('userOrders'));
    }

    /**
     * @param StoreOrderRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $cartProducts = Cart::query()->where('user_id', auth()->id())->get();
        if($cartProducts->isNotEmpty()) {
            dispatch(new PlaceOrderJob(auth()->id()));
            return redirect()->route('orders.index', auth()->id())
                ->withSuccess('New order is added successfully');
        }else {
            return redirect()->route('cart.index', auth()->id())
                ->withErrors(['msg' => 'New order cannot be added without products in cart!']);
        }
    }

    /**
     * @param $orderId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show($orderId)
    {
        return view('orders.show', [
            'order' => Order::find($orderId)
        ]);
    }

    /**
     * @param $orderId
     * @return RedirectResponse
     */
    public function destroy($orderId):RedirectResponse
    {
        dispatch(new RefundOrderJob($orderId));
        return redirect()->route('orders.index', auth()->id())
            ->withSuccess('Order is deleted successfully');
    }
}
