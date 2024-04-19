<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\Products\AddProductJob;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\User;
use App\Services\Constants;
use http\Env\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('products.index', [
            'products' => Product::latest()->paginate(8)
        ]);
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function dashboardProducts()
    {
        $categories = Category::all();
        $dashboardProducts = Product::all();
        return view('dashboard', compact('dashboardProducts', 'categories'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function search(Request $request)
    {
        $data = $request->input('search');
        $dashboardProducts = Product::where('name', 'LIKE', '%' . $data . '%')->paginate(8);
        return view('dashboard', compact('dashboardProducts'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function sortCategory(Request $request)
    {
        $categories = Category::all();
        $categoryName = ($request->filled('sort')) ? $request->input('sort') : '';

        if ( empty($categoryName) ) {
            $dashboardProducts = Product::latest()->paginate(8);
            return redirect()->route('dashboard');
        } else {
            $categoryId = Category::where('name', $categoryName)->value('id');
            $dashboardProducts = Product::where('category_id', $categoryId)->latest()->paginate(8);
        }
        return view('dashboard', compact('dashboardProducts', 'categories','categoryName'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function searchProduct(Request $request)
    {
        $dataProduct = $request->input('searchProduct');
        $products = Product::where('name', 'LIKE', '%' . $dataProduct . '%')->paginate(8);
        return view('products.index', compact('products'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * @param StoreProductRequest $request
     * @return RedirectResponse
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
     * @param Product $product
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Product $product)
    {
        return view('products.show', [
            'product' => $product
        ]);
    }

    /**
     * @param Product $product
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }


    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
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
     * @param Product $product
     * @return RedirectResponse
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
