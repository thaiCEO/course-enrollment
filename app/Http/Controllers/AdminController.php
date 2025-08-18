<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function showLogin() {
        return view('login_form');
    }

  public function loginProccess(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $credentials = $request->only('email', 'password');

    // Attempt login with admin guard
    if (Auth::guard('admin')->attempt($credentials)) {
        $admin = Auth::guard('admin')->user();

        if ($admin->is_Admin == 1) {
            return redirect()->route('dashboard.index')->with('success', 'Login successful');
        } else {
            Auth::guard('admin')->logout();
            return redirect()->route('login.show')->with('error', 'You are not authorized as admin');
        }
        
    }

    return redirect()->back()->with('error', 'Invalid email or password');
}


}
