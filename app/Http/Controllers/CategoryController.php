<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function indexCategory()
    {
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function createCategory()
    {
        return view('category.create');
    }

    /**
     * @param StoreCategoryRequest $request
     * @return mixed
     */
    public function storeCategory(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('products.index')->withSuccess('New category is added successfully');
    }

    /**
     * @param $categoryId
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function editCategory($categoryId)
    {
        $category = Category::where('id', $categoryId)->first();
        return view('category.edit', compact('category'));
    }

    /**
     * @param UpdateCategoryRequest $request
     * @return mixed
     */
    public function updateCategory(UpdateCategoryRequest $request)
    {
        $category = Category::where('id', $request->categoryId)->first();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')
            ->withSuccess('Category is updated successfully');
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function deleteCategory($categoryId)
    {
        $category  = Category::where('id', $categoryId)->first();
        $category->delete();

        return redirect()->route('category.index')->withSuccess('Category was removed successfully');
    }
}
