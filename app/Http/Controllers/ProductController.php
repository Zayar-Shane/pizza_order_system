<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //redirect product list Page
    public function listPage()
    {
        $pizza = Product::select('products.*', 'categories.name as category_name')
            ->when(request('key'), function ($query) {
                $query->where('products.name', 'like', '%' . request('key') . '%');
            })
            ->join('categories', 'products.category_id', 'categories.id')
            ->orderBy('products.created_at', 'desc')
            ->paginate(3);
        // dd($pizza->toArray());
        $pizza->appends(request()->all());
        return view('admin.product.pizzaList', compact('pizza'));
    }

    // redirect product create page
    public function createPage()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.product.create', compact('categories'));
    }

    // create product
    public function create(Request $request)
    {
        $this->productValidationCheck($request, "create");
        $data = $this->requestProductData($request);
        $filename = uniqid() . '_' . $request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public', $filename);
        $data['image'] = $filename;
        Product::create($data);
        return redirect()->route('product#listPage');
    }

    // delete product
    public function delete($id)
    {
        $data = Product::where('id', $id)->first();
        $filename = $data->image;
        Storage::delete('public/' . $filename); //delete Image
        Product::where('id', $id)->delete();
        return redirect()->route('product#listPage')->with(['deleteSuccess' => 'Product deleted successfully...']);
    }

    // redirect product details Page
    public function detail($id)
    {
        $pizza = Product::select('products.*', 'categories.name as category_name')
            ->join('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        return view('admin.product.detail', compact('pizza'));
    }

    // redirect product Update Page
    public function updatePage($id)
    {
        $categories = Category::select('id', 'name')->get();
        $pizza = Product::where('id', $id)->first();
        return view('admin.product.update', compact('pizza', 'categories'));
    }

    // update product
    public function update(Request $request)
    {
        $this->productValidationCheck($request, "update");
        $data = $this->requestProductData($request);
        if ($request->hasFile('pizzaImage')) {
            $dbImage = Product::select('image')->where('id', $request->pizzaId)->first();
            $dbImage = $dbImage->image;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $filename = uniqid() . '_' . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public', $filename);
            $data['image'] = $filename;
        }
        Product::where('id', $request->pizzaId)->update($data);
        return redirect()->route('product#listPage');
    }

    // check product validation
    private function productValidationCheck($request, $action)
    {
        $validationRules = [
            'pizzaName' => 'required|min:5|unique:products,name,' . $request->pizzaId,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required|min:8',
            'waitingTime' => 'required',
            'pizzaPrice' => 'required',
        ];

        $validationRules['pizzaImage'] = $action == 'create' ? 'required|mimes:jpg,jpeg,png,webp|file' : 'mimes:jpg,jpeg,png,webp|file';
        Validator::make($request->all(), $validationRules)->validate();
    }

    // request product data
    private function requestProductData($request)
    {
        return [
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->waitingTime,
            'category_id' => $request->pizzaCategory,
        ];
    }
}
