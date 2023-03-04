<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    // GET
    //get all products list
    public function productList()
    {
        $products = Product::get();
        return response()->json($products, 200);
    }

    // get all category list
    public function categoryList()
    {
        $category = Category::orderBy('id', 'desc')->get();
        return response()->json($category, 200);
    }

    // get all order list
    public function orderList()
    {
        $orderList = OrderList::get();
        return response()->json($orderList, 200);
    }

    // get all order
    public function order()
    {
        $order = Order::get();
        return response()->json($order, 200);
    }

    // get all contacts
    public function contacts()
    {
        $contacts = Contact::get();
        return response()->json($contacts, 200);
    }

    // POST
    public function createCategory(Request $request)
    {
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $response = Category::create($data);
        return response()->json($response, 200);
    }

    // create contact
    public function createContact(Request $request)
    {
        $data = $this->getContactData($request);
        $response = Contact::orderBy('id', 'desc')->create($data);
        return response()->json($response, 200);
    }

    // delete category by post method
    public function deleteCategory(Request $request)
    {
        $data = Category::where('id', $request->id)->first();
        if (isset($data)) {
            Category::where('id', $request->id)->delete();
            return response()->json(['status' => 'true', 'message' => 'delete success', 'deleteData' => $data], 200);

        };
        return response()->json(['status' => 'false', 'message' => 'There is no cateogy...'], 500);
    }

    // delete contact by get post method
    public function deleteContact($id)
    {
        $data = Contact::where('id', $id)->first();
        if (isset($data)) {
            Contact::where('id', $id)->delete();
            return response()->json(['status' => 'true', 'message' => 'delete contact successs...', 'deleteData' => $data], 200);
        };
        return response()->json(['status' => 'false', 'message' => 'There is no contact message...'], 500, );
    }

    // get category details
    public function categoryDetails($id)
    {
        $data = Category::where('id', $id)->first();
        if (isset($data)) {
            return response()->json(['status' => 'true', 'categoryDetails' => $data], 200);

        }
        ;
        return response()->json(['status' => 'false', 'message' => 'There is no cateogy...'], 500);

    }

    public function updateCategory(Request $request)
    {
        $data = $this->requestCategoryData($request);
        $dbSource = Category::where('id', $request->category_id)->first();
        if (isset($dbSource)) {
            Category::where('id', $request->category_id)->update($data);
            $response = Category::where('id', $request->category_id)->first();
            return response()->json(['status' => 'true', 'categoryDetails' => $response], 200);

        };
        return response()->json(['status' => 'false', 'message' => 'There is no category'], 500);
    }

    // get contact data
    private function getContactData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    // request category data
    private function requestCategoryData($request)
    {
        return [
            'name' => $request->category_name,
            'updated_at' => Carbon::now(),
        ];
    }
}
