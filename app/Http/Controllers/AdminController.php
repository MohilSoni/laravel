<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function admin()
    {
        Auth::guard('admin')->logout();
        Auth::guard('user')->logout();
        return view('login');
    }

    public function login(AdminLoginRequest $request)
    {
        Auth::guard('user')->logout();
        $admin = Admin::where('email', $request->email)->first();
        if ($admin == null) {
            return redirect()->route('admin');
        } else {
            if (Hash::check($request->password, $admin->password)) {
                if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    return redirect()->route('displayusers');
                } else {
                    return redirect()->route('admin');
                }
            }
        }

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin');
    }
}
