<?php

namespace App\Services;

use App\Models\Cart;

class CartService extends BaseService
{
    public function setModel()
    {
        return new Cart();
    }
    public function findByUserId($userId)
    {
        $cart = Cart::where('user_id', $userId)->with(['productVariant.product.specifications', 'productVariant.images'])->get();
        return $cart->map(function ($cart) {
            return [
                'id' => $cart->id,
                'product_variant_id' => $cart->product_variant_id,
                'product' => $cart->productVariant->product->title . ' Màu ' . $cart->productVariant->color,
                'quantity' => $cart->quantity,
                'current_price' => $cart->productVariant->price,
                'price' => $cart->productVariant->price * (1 - $cart->productVariant->product->discount / 100),
                'variant_images' => $cart->productVariant->images->first()->image_url,
                'totalAmount' => $cart->productVariant->price * (1 - $cart->productVariant->product->discount / 100) * $cart->quantity
            ];
        });
    }
    public function updateByUserId($userId, $data)
    {   
        $result = false;
        if ($data['quantity'] == 0) {
            $result = $this->deleteByUserId($userId, $data['product_variant_id']);
        } else {
            $cart = Cart::where('user_id', $userId)->where('product_variant_id', $data['product_variant_id'])->first();
            $productVariant = \App\Models\ProductVariant::find($data['product_variant_id']);
            $newQuantity = $cart ? $cart->quantity + $data['quantity'] : $data['quantity'];
            if ($newQuantity > $productVariant->stock) {
                return  false;
            }    
            if ($cart) {
                $result = $cart->update(['quantity' => $newQuantity]);
            } else {
                $result = Cart::create([
                    'user_id' => $userId,
                    'product_variant_id' => $data['product_variant_id'],
                    'quantity' => $data['quantity']
                ]);
            }
        }
        if($result == false) return false;
        return $this->findByUserId($userId);
    }

    public function deleteByUserId($userId, $productVariant)
    {
        return Cart::where('user_id', $userId)->where('product_variant_id', $productVariant)->delete();
    }
}
