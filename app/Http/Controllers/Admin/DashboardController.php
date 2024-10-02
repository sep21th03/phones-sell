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
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('dashboard',  ['total_products' => Product::count()]);
    }
    public function manager_category()
    {
        if (Auth::user()) {
            $newCategory = Category::newCategory();
            $total_new_categories = $newCategory['count'];
            return view('category.index.list', ['total_categories' => Category::count(), 'total_new_categories' => $total_new_categories]);
        }
        return redirect()->route('login');
    }
    public function manager_product()
    {
        if (Auth::user()) {
            $categories = Category::all();
            return view('product.index.list', ['categories' => $categories]);
        }
        return redirect()->route('login');
    }
    public function detai_product($id)
    {
        if (Auth::user()) {
            $product = Product::with('specifications', 'variants', 'variants.images')->find($id);
            if (!$product) {
                abort(404);
            }
            $product->variants = $product->variants->isNotEmpty() ? $product->variants->map(function ($variant) {
                return (object) [
                    'id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'rom_id' => $variant->rom_id,
                    'color' => $variant->color,
                    'price' => $variant->price,
                    'availability' => $variant->availability,
                    'stock' => $variant->stock,
                    'rom' => (object) [
                        'id' => $variant->rom->id,
                        'capacity' => $variant->rom->capacity,
                    ],
                    'images' => $variant->images->isNotEmpty()
                        ? $variant->images->map(function ($image) {
                            return (object) [
                                'id' => $image->id,
                                'product_variant_id' => $image->product_variant_id,
                                'image_url' => $image->image_url,
                            ];
                        })
                        : [['image_url' => 'assets/img/products/template_img.jpg']],
                ];
            }) : collect([(object) [
                'id' => null,
                'product_id' => null,
                'rom_id' => 1,
                'color' => null,
                'price' => null,
                'availability' => null,
                'stock' => null,
                'rom' => (object) [
                    'id' => null,
                    'capacity' => null,
                ],
                'images' => [['image_url' => 'assets/img/products/template_img.jpg']],
            ]]);


            $categories = Category::all();
            $roms = Rom::all();
            if (!$product) {
                abort(404);
            }
            return view('product.edit.detail', compact(['product', 'categories', 'roms']));
        }

        return redirect()->route('login');
    }
    public function add_product()
    {
        if (Auth::user()) {
            $categories = Category::all();
            $roms = Rom::all();
            return view('product.create.add', compact(['categories', 'roms']));
        }
        return redirect()->route('login');
    }
}
