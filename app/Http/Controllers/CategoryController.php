<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
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

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('categories.form', [
            'item' => $category
        ]);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->updateCategory($request->getData(), $request->getImage(), $category);

        return redirect()->route('categories.index')->with('status', 'Category updated.');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->deleteCategory($category);

        return redirect()->route('categories.index')->with('status', 'Category deleted.');
    }
}
