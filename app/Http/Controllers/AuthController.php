<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //direct login Page
    public function loginPage()
    {
        return view('login');
    }

    //direct Register Page
    public function registerPage()
    {
        return view('register');
    }

    // Redirect dashboard
    public function dashboard()
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('category#list');
        } else {
            return redirect()->route('user#home');
        }
    }

}
