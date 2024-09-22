<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function postlogin(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        try {
            $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 1) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'You do not have admin access.');
            }
        }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Login failed');
        }
    }
}
