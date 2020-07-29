<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * @return View
     */
    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();

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
        $this->categoryService->createCategory($request->getData(), $request->getImage());

        return redirect()->route('categories.index')
            ->with('status', 'Category created.');
    }

}
