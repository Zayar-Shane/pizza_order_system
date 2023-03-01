<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // password change password page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
    }

    // change password
    public function changePassword(Request $request)
    {
        /*
        1.all password fields are required.
        2.new pass && confirm pass must be greater than 6 and less than 10
        3.new pass && confirm pass must be the same
        4.old pass must be the same with db:password
        5. password change
         */

        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashPassword = $user->password; //db hash value

        if (Hash::check($request->oldPassword, $dbHashPassword)) {
            User::where('password', Auth::user()->password)->update([
                'password' => Hash::make($request->newPassword),
            ]);
            // Auth::logout();
            // return redirect()->route('auth#loginPage');
            return back()->with(['updatePass' => 'Passward Update Success...']);
        }
        return back()->with(['notMatch' => 'The Old Password not Match. Try Again.']);

    }

    // redirect admin details page
    public function details()
    {
        return view('admin.account.details');
    }

    // redirect admin edit page
    public function edit()
    {
        return view('admin.account.edit');
    }

    // update admin profile
    public function update(Request $request, $id)
    {

        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        if ($request->hasFile('image')) {
            // 1.oldImage => check == delete | store
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;

            if ($dbImage != null) {
                Storage::delete(['public/' . $dbImage]);
            }
            $filename = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $filename);
            $data['image'] = $filename;
        }
        User::where('id', $id)->update($data);
        return redirect()->route('admin#details')->with(['upateSuccess' => 'Admin Account Updated...  ']);
    }

    // redirect account list Page
    function list() {
        $data = User::when(request('key'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('email', 'like', '%' . request('key') . '%')
                ->orWhere('gender', 'like', '%' . request('key') . '%')
                ->orWhere('phone', 'like', '%' . request('key') . '%')
                ->orWhere('address', 'like', '%' . request('key') . '%');
        })
            ->where('role', 'admin')->paginate(3);
        $data->appends(request()->all());
        return view('admin.account.list', compact('data'));
    }

    // account list delete
    public function delete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Account Deleted Successfully....']);
    }

    // ajax admin change role
    public function roleChange(Request $request)
    {
        User::where('id', $request->user_id)->update([
            'role' => $request->role,
        ]);
    }

    // request user data
    private function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'created_at' => Carbon::now(),
        ];
    }

    // account validation check
    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'image' => 'mimes:jpg,jpeg,png,webp|file',
            'address' => 'required',
        ])->validate();
    }

    // password validation check
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword',
        ], [
            'oldPassword.required' => 'old password ဖြည့်ရန် လိုအပ်သည်။',
            'oldPassword.min' => 'အနည်းဆုံး 6လုံး အထက်ရှိရမည်။',
            'oldPassword.max' => 'အများဆုံး 10အောက်သာ ရှိရမည်။',
            'newPassword.required' => 'new password ဖြည့်ရန် လိုအပ်သည်။',
            'newPassword.min' => 'အနည်းဆုံး 6လုံး အထက် ရှိရမည်။',
            'newPassword.max' => 'အများဆုံး ၁၀အောက်သာ ရှိရမည်။',
            'confirmPassword.required' => 'confirm password ဖြည့်ရန် လိုအပ်သည်။',
            'confirmPassword.min' => 'အနည်းဆုံး 6လုံး အထက် ရှိရမည်။',
            'confirmPassword.max' => 'အများဆုံး ၁၀အောက်သာ ရှိရမည်။',
            'confirmPassword.same' => 'confirm password သည် old password နှင့် ကိုက်ညီရမည်။',
        ])->validate();
    }
}
