<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploading;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use MediaUploading;

    public function index(): View
    {
        $products = Product::where('user_id', Auth::id())->get();

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::all()->pluck('name','id');

        return view('admin.products.create', compact('categories'));
    }

    private function generateProductCode()
    {
        $date = now()->format('Ymd');
        $stripe = "-";
        $lastProduct = Product::orderBy('id', 'desc')->first();
        $id = $lastProduct ? $lastProduct->id + 1 : 1;
        return $date . $stripe . str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $productCode = $this->generateProductCode();
        $product = Product::create($request->validated() +
        [
            'user_id' => Auth::id(),
            'product_code' => $productCode
        ]);

        return redirect()->route('products.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Product $product, $id): View
    {
        $product = Product::find($id);
        if ($product->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Access denied.');
        }
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::all()->pluck('name','id');

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('products.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function massDestroy()
    {
        Product::whereIn('id', request('ids'))->delete();

        return response()->noContent();
    }

    public function search(Request $request, $id){
        $product = Product::find($id);
        if ($product->user_id != Auth::id())
        {
            return redirect()->back()->with('error', 'Access denied.');
        }
        $products = Product::where('name', 'like', '%' . $request->search . '%')->get();
        return json_encode($products);
    }
}
