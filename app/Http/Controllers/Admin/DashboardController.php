<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
    public function manager_category(){
        if(Auth::user()){
            return view('admin.category.list');
        }
        return redirect()->route('admin.login');
    }
    public function manager_product(){
        if(Auth::user()){
            return view('admin.product.list');
        }
        return redirect()->route('admin.login');
    }
}
