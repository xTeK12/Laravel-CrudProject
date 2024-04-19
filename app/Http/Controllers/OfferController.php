<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Order_details;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class OfferController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function indexOffer()
    {
        $offers = Offer::all();
        return view('offers.index', compact('offers'));
    }

    /**
     * @param $productId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function createOffer($productId)
    {
        $product = Product::where('id', $productId)->first();
        return view('offers.create', compact('product'));
    }

    /**
     * @param StoreOfferRequest $request
     * @return RedirectResponse
     */
    public function storeOffer(StoreOfferRequest $request)
    {
        $productId = $request->productId;
        $product = Product::where('id', $productId)->first();

        $existingOffer = Offer::where('user_id', auth()->id())
            ->where('product_id', $productId)
            ->exists();

        if($existingOffer) {
            return back()->withErrors(['msg' => 'This offer exists once']);
        }

        if($product->ownerID === auth()->id()) {
            return back()->withErrors(['msg' => 'You can not make offer to yourself']);
        }

        $newOffer = new Offer();
        $newOffer->user_id = auth()->id();
        $newOffer->product_id = $productId;
        $newOffer->quantity = $request->quantity;
        $newOffer->price = $request->price;
        $newOffer->save();

        return redirect()->route('offer.index')->withSuccess('Offer sent successfully');
    }

    /**
     * @param $offerId
     * @return mixed
     */
    public function acceptOffer($offerId)
    {
        $offer = Offer::where('id', $offerId)->first();
        $product = Product::where('id', $offer->product_id)->first();

        $newOrder = new Order();
        $newOrder->user_id = $offer->user_id;
        $newOrder->save();

        $newOrderDetails = new Order_details();
        $newOrderDetails->order_id = $newOrder->id;
        $newOrderDetails->product_id = $offer->product_id;
        $newOrderDetails->quantity = $offer->quantity;
        $newOrderDetails->save();

        $product->quantity -= $offer->quantity;
        $product->save();

        $offer->delete();
        return redirect()->route('offer.index')->withSuccess('Offer was accepted successfully');
    }

    /**
     * @param $offerId
     * @return mixed
     */
    public function deleteOffer($offerId)
    {
        $offer = Offer::where('id', $offerId)->first();
        $offer->delete();

        return redirect()->route('offer.index')->withSuccess('Offer was removed successfully');
    }
}
