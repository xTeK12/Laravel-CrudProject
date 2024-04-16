<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\Products\AddProductJob;
use App\Models\Media;
use App\Models\Product;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('products.index', [
            'products' => Product::latest()->paginate(8)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function dashboardProducts()
    {
        $dashboardProducts = Product::all();
        return view('dashboard', compact('dashboardProducts'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function search(Request $request)
    {
        $data = $request->input('search');
        $dashboardProducts = Product::where('name', 'LIKE', '%' . $data . '%')->paginate(8);
        return view('dashboard', compact('dashboardProducts'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function searchProduct(Request $request)
    {
        $dataProduct = $request->input('searchProduct');
        $products = Product::where('name', 'LIKE', '%' . $dataProduct . '%')->paginate(8);
        return view('products.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create() : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) :RedirectResponse
    {
        $userId = auth()->id();

        if($request->hasFile('image')) {
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('public/media/'.time().'_'.$filename);
        }
        else{
            $path = 'storage/media/default.png';
        }

        dispatch(new AddProductJob($request->except('image', '_token'), $userId, $path));

        return redirect()->route('products.index')
            ->withSuccess('New product is added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) : \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $request->validate([
            'code' => 'unique:products,code,' . $product->id
        ]);
        if (! Gate::allows('update-product', $product)) {
            return redirect()->route('products.index');
        }
        $product->update($request->all());
        return redirect()->route('products.index')
            ->withSuccess('Product is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Product $product) : RedirectResponse
    {
        if (! Gate::allows('destroy-product', $product)) {
            return redirect()->route('products.index');
        }
        $media = Media::where('product_id', $product->id)->first();
        if ($media) {
            Storage::delete($media->path);
            $media->delete();
        }
        $product->delete();

        return redirect()->route('products.index')
            ->withSuccess('Product is deleted successfully');
    }
}
