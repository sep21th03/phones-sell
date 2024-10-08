<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\StoreOrderRequest;
use App\Http\Requests\Api\Order\UpdateOrderRequest;
use App\Http\Requests\Api\Order\VnpayPaymentRequest;
use App\Http\Requests\Admin\Order\UpdateOrderStatusRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function getListByUser()
    {
        $result = $this->orderService->getListByUser();
        return jsonResponse('success', 'Danh sách đơn hàng', $result);
    }
    public function getDetailOrder($id)
    {
        $result = $this->orderService->getDetailOrder($id);
        return jsonResponse('success', 'Chi tiết đơn hàng', $result);
    }
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();
        $result = $this->orderService->store($data);
        return $result
            ? jsonResponse('success', 'Tạo đơn hàng thành công', $result)
            : jsonResponse('error', 'Tạo đơn hàng thất bại', $result);
    }
    public function update(UpdateOrderRequest $request)
    {
        $data = $request->validated();
        $result = $this->orderService->userUpdate($data['id'], $data);
        return $result
            ? jsonResponse('success', 'Cập nhật đơn hàng thành công', $result)
            : jsonResponse('error', 'Cập nhật đơn hàng thất bại', $result);
    }
    public function delete($id)
    {
        $result = $this->orderService->delete($id);
        return $result
            ? jsonResponse('success', 'Xóa đơn hàng thành công')
            : jsonResponse('error', 'Xóa đơn hàng thất bại');
    }
    public function updateStatus(UpdateOrderStatusRequest $request)
    {
        $data = $request->validated();
        $result = $this->orderService->update($data['id'], $data);
        return $result
            ? jsonResponse('success', 'Cập nhật trạng thái đơn hàng thành công', $result)
            : jsonResponse('error', 'Cập nhật trạng thái đơn hàng thất bại');
    }
}
