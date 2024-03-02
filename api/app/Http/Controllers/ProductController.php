<?php
namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService
    ) {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $products = $this->productService->findAll();
        $categories = $this->categoryService->findAll();

        $selected = [];
        return view('product.index', compact('products', 'categories', 'selected'));
    }

    /**
     * @return View
     */
    public function add(): View
    {
    	$categories = $this->categoryService->findAll();
    	return view('product.add', compact('categories'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:255',
            'description' => 'required',
        ]);

        if(!$validator->fails()){
            $this->productService->create($request->all());
        }

        return redirect()->route('product.index');
    }

    /**
     * @param $id
     * @return View|RedirectResponse
     */
    public function edit($id): View|RedirectResponse
    {
        $product = $this->productService->find($id);
        $categories = $this->categoryService->findAll();
        $selected_cat = [];
        $selected = [];
        $images = $product->images;

        if (!empty($product->categories)) {
            foreach ($product->categories as $category) {
                $selected_cat[] = $category->pivot->category_id;
            }
            return view('product.edit', compact('product', 'categories', 'selected_cat', 'images', 'selected'));
        }

        return redirect()->route('product.index');
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->productService->update($id, $request->all());

        return redirect()->route('product.index');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $this->productService->delete($id);

        return redirect()->route('product.index');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $name = $request->input('name');
        $categoriesSearch = $request->input('categories') ?: [];
        $products = $this->productService->search($name, $categoriesSearch);

        $categories = $this->categoryService->findAll();

        return view('product.index', compact('products', 'categories', 'selected_cat', 'search'));
    }
}
