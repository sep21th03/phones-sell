<?php

namespace App\Services;

use App\Jobs\UpdateOrderStatusJob;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ProductOption;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService extends BaseService
{
    public function setModel()
    {
        return new Order();
    }

    public function getListByUser()
    {
        $user = Auth()->user();
        return $this->model->where('user_id', $user->id)->orderBy('id', 'desc')->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'code' => $order->code,
                'created_at' => $order->created_at->format('H:i d/m/Y '),
                'status' => Order::STATUS_LABEL[$order->status] ?? 'Đang chờ',
                'total_price' => $order->total_price,
            ];
        });
    }
    public function getDetailOrder($id)
    {
        $order = $this->model->find($id);
        return [
            '$id' => $order->id,
            'code' => $order->code,
            'name' => $order->user_name,
            'user' => $order->user,
            'phone' => $order->phone,
            'status_label' => Order::STATUS_LABEL[$order->status] ?? 'Đang chờ',
            'status' => $order->status,
            'payment_method' => Order::PAYMENT_LABEL[$order->payment_method] ?? 'Lỗi',
            'total_price' => $order->total_price,
            'note'  => $order->note,
            'message' => $order->message,
            'created_at' => $order->created_at->format('H:i d/m/Y '),
            'order_details' => $order->orderDetails->map(function ($orderDetail) {
                return [
                    'id' => $orderDetail->id,
                    'product_name' => $orderDetail->productVariant->product->title . ' (Màu ' . $orderDetail->productVariant->color . ')',
                    'quantity' => $orderDetail->quantity,
                    'price' => $orderDetail->price
                ];
            }),
            'address' => $order->address
        ];
    }
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $user = Auth()->user();
            $orderData = [
                'code' => 'MB' . $user->id . 'P' . time() . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2),
                'user_id' => $user->id,
                'user_name' => $data['first_name'] . ' ' . $data['last_name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'note' => $data['note'] ?? '',
                'message' => $data['message'] ?? '',
                'total_price' => $data['total_price'],
                'payment_method' => $data['payment_method'],
                'shipping_fee' => $data['shipping_fee'] ?? 20000,
                'status' =>  $data['payment_method'] == 0 ? $this->model::STATUS_WAITING_PAYMENT : $this->model::STATUS_WAITING,
            ];
            $order = parent::store($orderData);
            $order_details = [];
            foreach ($data['order_details'] as $item) {
                $variant = ProductVariant::find($item['product_variant_id']);
                if (!$variant) {
                    throw new \Exception("Product variant not found: " . $item['product_variant_id']);
                }
                if ($variant->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product variant: " . $item['product_variant_id']);
                }
                $variant->stock -= $item['quantity'];
                $variant->save();

                $order_details[] = [
                    'order_id' => $order->id,
                    'product_variant_id' => $item['product_variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ];
            }
            $order->orderDetails()->createMany($order_details);
            $cartIds = [];
            foreach ($data['order_details'] as $item) {
                $cartIds[] = $item['id'];
            }
            Cart::whereIn('id', $cartIds)->delete();
            DB::commit();
            dispatch(new UpdateOrderStatusJob($user->email, 'Bạn đã đặt hàng thành công, xin vui lòng đợi xác nhận. Mã đơn hàng của bạn là: ', $order->code));
            return [
                'code' => $order->code,
                'total_price' => $order->total_price,
                'created_at' => $order->created_at->format('H:i d/m/Y ')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage()
            ];
        }
    }
    public function update($id, $data)
    {
        $order = $this->model->find($id);
        if($order->status != $data['status']) {
            switch($data['status']) {
                case $this->model::STATUS_CANCEL:
                    $content = "Đơn hàng #$order->code của bạn đã bị hủy bỏ";
                    break;
                case $this->model::STATUS_WAITING:
                    $content = "Đơn hàng #$order->code của bạn đang chờ xác nhận";
                    break;
                case $this->model::STATUS_SUCCESS:
                    $content = "Đơn hàng #$order->code của bạn đã được giao thành công";
                    break;
                case $this->model::STATUS_CONFIRM:
                    $content = "Đơn hàng #$order->code đã được xác nhận và sẽ sớm được giao tới bạn";
                    break;
                case $this->model::STATUS_SHIPPING:
                    $content = "Đơn hàng #$order->code đang trên đường giao tới bạn";
                    break;
                case $this->model::STATUS_WAITING_PAYMENT:
                    $content = "Đơn hàng #$order->code đang đang chờ thanh toán, hãy thanh toán đơn hàng ngay";
                    break;
            }
            dispatch(new UpdateOrderStatusJob($order->user->email, $order->user_name, $content));
        }
        return $order->update($data);
    }
    public function userUpdate($id, $data)
    {
        $order = $this->model->find($id);
        if($order->status !== $this->model::STATUS_WAITING){
            return false;
        }
        return parent::update($id, $data);
    }
    public function delete($id)
    {
        $order = $this->model->find($id);
        if($order->status!== $this->model::STATUS_WAITING){
            return false;
        }
        $order->orderDetails()->delete();
        return $order->delete();    
    }
}
