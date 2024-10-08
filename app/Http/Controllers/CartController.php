<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\UpdateCartRequest;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getMyCart()
    {
        $myCart = $this->cartService()->findByUserId(Auth::user()->id);
        return jsonResponse('success', 'Giỏ hàng',$myCart);
    }

    public function updateMyCart(UpdateCartRequest $request)
    {
        $data = $request->validated();
        $myCart = $this->cartService()->updateByUserId(Auth::user()->id, $data);
        return jsonResponse($myCart ? 'success' : 'error',  $myCart ? 'Cập nhật thành công!' : 'Có lỗi xảy ra, xin vui lòng tải lại trang và thử lại.', $myCart);
    }

    public function cartService()
    {
        return app(CartService::class);
    }
}
