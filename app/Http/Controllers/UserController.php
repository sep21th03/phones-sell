<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\Admin\User\UpdateUserRequest;
class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $result = $this->userService->getAllUsers();
        return $result
            ? jsonResponse('success',  'Danh sách người dùng', $result)
            : jsonResponse('error', 'Không tìm thấy danh sách người dùng!');
    }
    public function update(UpdateUserRequest $request){
        $data = $request->validated();
        $result = $this->userService->update($data['id'], $data);
        return $result
        ? jsonResponse('success', 'Cập nhật người dùng thành công!')
        : jsonResponse('error', 'Cập nhật người dùng thất bại!');
    }
}
