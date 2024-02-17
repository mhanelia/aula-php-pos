<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    )
    {

    }

    /**
     * @return View
     */
    public function index(): View
    {
        $categories = $this->categoryService->findPaginate(qtd: 10);
        return view('category.index', compact('categories'));
    }

    public function add(): View
    {
        return view('category.add');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'image' => 'required|image',
        ]);

        $this->categoryService->create($request->all());

        return redirect()->route('category.index');
    }

    public function delete($id): RedirectResponse
    {
        $this->categoryService->delete($id);
        return redirect()->route('category.index');
    }

    public function edit($id): View
    {

        $category = $this->categoryService->find($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|min:1|max:255',
            'image' => 'image',
            'deleted_at' => 'sometimes|string',
        ]);
        $this->categoryService->update($request->all(), $id);
        return redirect()->route('category.index');
    }

    public function search(Request $request): View
    {
        $categories = $this->categoryService->search($request->all());
        return view('category.index', compact('categories'));
    }

}
