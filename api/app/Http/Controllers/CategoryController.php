<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ){

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
}
