<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //redirect category list page
    function list() {
        $categories = Category::when(request('key'), function ($query) {
            $key = request('key');
            $query->where('name', 'like', '%' . $key . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(4);
        $categories->appends(request()->all());
        return view('admin.category.list', compact('categories'));
    }

    //direct cateate page
    public function createPage()
    {
        return view('admin.category.create');
    }

    // create category
    public function create(Request $request)
    {
        $this->cateValidationCheck($request);
        $data = $this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list');
    }

    // delete category
    public function delete($id)
    {
        Category::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Category deleted....']);
    }

    // edit category
    public function edit($id)
    {
        $categoryData = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('categoryData'));
    }

    // update category
    public function update(Request $request)
    {
        $this->cateValidationCheck($request);
        $updateData = $this->requestCategoryData($request);
        Category::where('id', $request->categoryID)->update($updateData);
        return redirect()->route('category#list');
    }

    // category validation check
    private function cateValidationCheck($request)
    {
        Validator::make($request->all(), [
            'categoryName' => 'required|min:4|unique:categories,name,' . $request->categoryID,
        ],
            [
                'categoryName.required' => 'The category name is required',
                'categoryName.min' => 'The category name must be at least 5 characters',
                'categoryName.unique' => 'The category name has been already taken',
            ])->validate();
    }

    // Request Category Data
    public function requestCategoryData($request)
    {
        return [
            'name' => $request->categoryName,
        ];
    }
}
