<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Restaurant;
use Illuminate\Http\RedirectResponse;
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
        Category::query()->create($request->getData());

        return redirect()->route('categories.index')
            ->with('status', 'Category created.');
    }

}
