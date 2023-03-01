<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //redirect contact page
    public function contactPage()
    {
        return view('user.contact.contact');
    }

    // contact to admin
    public function contactToAdmin(Request $request)
    {
        $this->checkContactMessage($request);
        $data = $this->requestContactData($request);
        Contact::create($data);
        return back()->with(['contactSuccess' => 'Message send Success...']);
    }

    // get data from admin pannel
    public function message()
    {
        $data = Contact::get();
        return view('admin.contact.message', compact('data'));
    }

    // delete message from admin
    public function deleteMessage($id)
    {
        Contact::find($id)->delete();
        return back()->with(['deleteSuccess' => 'Message delete success...']);
    }

    // view message
    public function viewMessage($id)
    {
        $message = Contact::where('id', $id)->first();
        return view('admin.contact.viewMessage', compact('message'));
    }

    // check Contact Message
    private function checkContactMessage($request)
    {
        $validationRules = [
            'name' => 'required|min:5',
            'email' => 'required',
            'message' => 'required|min:20',
        ];
        Validator::make($request->all(), $validationRules)->validate();
    }

    // request contact data
    private function requestContactData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ];
    }
}
