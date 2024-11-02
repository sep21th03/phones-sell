<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rom;
use App\Models\Order;
use App\Services\ProductService;
use App\Services\OrderService;
use App\Services\UserService;
class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }
        $outOfStockProducts = $this->productService()->countOutOfStockProducts();
        $getReviewsAll = $this->productService()->getReviewsAll();
        $successOrder = $this->orderService()->getOrderStatusSuccess();
        $waitingOrder = $this->orderService()->getOrderStatusWaiting();
        $getOrderLast = $this->orderService()->getOrderLast();
        $getNewUsersComparison = $this->userService()->getNewUsersComparison();
        $getCompletedOrdersComparison = $this->orderService()->getCompletedOrdersComparison();
        return view('dashboard',  
        [
            'outOfStockProducts' => $outOfStockProducts, 
            'successOrder' => $successOrder, 
            'waitingOrder' => $waitingOrder, 
            'getReviewsAll' => $getReviewsAll,
            'getOrderLast' => $getOrderLast,
            'getNewUsersComparison' => $getNewUsersComparison,
            'getCompletedOrdersComparison' => $getCompletedOrdersComparison,
        ]);
    }
    public function manager_user(){
        if (Auth::check()) {
            return view('user.index.list', ['total_users' => User::count()]);
        }
        return redirect()->route('auth.login');
    }
    public function manager_category()
    {
        if (Auth::user()) {
            return view('category.index.list', ['total_categories' => Category::count()]);
        }
        return redirect()->route('auth.login');
    }
    public function manager_product()
    {
        if (Auth::user()) {
            return view('product.index.list', ['total_products' => Product::count()]);
        }
        return redirect()->route('auth.login');
    }
    public function manager_order()
    {
        if (Auth::user()) {
            $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
            return view('order.index.list', ['total_order' => Order::count(), 'orders' => $orders]);
        }
        return redirect()->route('auth.login');
    }
    public function manager_review()
    {
        if (Auth::user()) {
            return view('review.index.list');
        }
        return redirect()->route('auth.login');
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

        return redirect()->route('auth.login');
    }
    public function add_product()
    {
        if (Auth::user()) {
            $categories = Category::all();
            $roms = Rom::all();
            return view('product.create.add', compact(['categories', 'roms']));
        }
        return redirect()->route('auth.login');
    }
    public function detail_order($id){
        if (Auth::user()) {
            $order = Order::with('user', 'orderDetails.productVariant.images', 'orderDetails.productVariant.product')->find($id);
            return view('order.edit.detail', compact(['order']));
        }
        return redirect()->route('auth.login');
    }
    public function history_order($id){
        if (Auth::user()) {
            $orders = Order::where('user_id', $id)->get();
            return view('order.edit.main', compact(['orders']));
        }
        return redirect()->route('auth.login');
    }

    public function productService()
    {
       return app(ProductService::class);
    }
    public function orderService()
    {
       return app(OrderService::class);
    }
    public function userService()
    {
       return app(UserService::class);
    }
}
