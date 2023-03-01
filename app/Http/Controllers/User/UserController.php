<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //redirect user home
    public function home()
    {
        $pizzas = Product::orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizzas', 'category', 'cart', 'order'));
    }

    // filter products according to category id
    public function filter($categoryId)
    {
        $pizzas = Product::where('category_id', $categoryId)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $order = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizzas', 'category', 'cart', 'order'));

    }

    // redirect change Password page
    public function changePage()
    {
        return view('user.password.change');
    }

    // pizza details page
    public function pizzaDetails($pizzaId)
    {
        $pizza = Product::where('id', $pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details', compact('pizza', 'pizzaList'));
    }

    // change user password
    public function change(Request $request)
    {
        $this->checkValidationPassword($request);
        $oldPassword = User::select('password')->where('id', Auth::user()->id)->first();
        $oldPassword = $oldPassword['password'];

        if (Hash::check($request->oldPassword, $oldPassword)) {
            $updatePassword = ['password' => Hash::make($request->newPassword)];
            User::where('password', Auth::user()->password)->update($updatePassword);
            return back()->with(['updateSuccess' => 'Password Update Success...']);
        }
        return back()->with(['notMatch' => 'The Old Password does not match.Try Again...']);
    }

    // redirect update profile page
    public function updateProfile()
    {
        return view('user.profile.account');
    }

    // update profile
    public function update(Request $request, $id)
    {
        $this->accountValidationCheck($request);
        $data = $this->requestUserData($request);
        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $filename = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $filename);
            $data['image'] = $filename;
        }
        User::where('id', $id)->update($data);
        return back()->with(['upateSuccess' => 'Admin Account Updated...  ']);
    }

    //redirect user list
    public function userList()
    {
        $users = User::where('role', 'user')->paginate('4');
        return view('admin.user.list', compact('users'));
    }

    // user change role
    public function userChangeRole(Request $request)
    {
        User::where('id', $request->userId)->update([
            'role' => $request->status,
        ]);
    }

    // request user data
    private function requestUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ];
    }

    // check password validation
    private function checkValidationPassword($request)
    {
        $validationRules = [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8|same:newPassword',
        ];

        Validator::make($request->all(), $validationRules)->validate();
    }

    // check account validation
    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' => 'mimes:jpg,jpeg,png,webp|file',
        ])->validate();
    }

}
