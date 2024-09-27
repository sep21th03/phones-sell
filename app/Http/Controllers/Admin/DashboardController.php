<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rom;

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
    public function detai_product($id){
        if(Auth::user()){
            $product = Product::with('specifications', 'variants', 'variants.images')->find($id);
            $categories = Category::all();
            $roms = Rom::all();
            if(!$product){
                abort(404);
            }
            return view('admin.product.detail', compact(['product', 'categories', 'roms']));
        }
    
        return redirect()->route('admin.login');
    }
    
}
