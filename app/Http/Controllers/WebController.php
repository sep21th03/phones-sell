<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class WebController extends Controller
{
    public function login_page(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function dashboard(){
        if(Auth::check()){
            return view('welcome');
        }
        return redirect()->route('login_page');
    }
    
    public function register(){
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        return view('register');
    }
}
