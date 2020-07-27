<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = Category::all();

        return view('categories.list', [
            'items' => $categories
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('categories.form');
    }

    /**
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse
    {
        $category = new Category($request->getData());
        if ($image = $request->getImage()) {
            $category->image = Storage::disk('public')->putFile('category_images', $image);
        }
        $category->save();

        return redirect()->route('categories.index')
            ->with('status', 'Category created.');
    }

}
