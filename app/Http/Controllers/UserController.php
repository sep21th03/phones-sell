<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\RoleService;
use Illuminate\Http\Request;
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
        $result = $this->userService->getAllUsersWithRoles();
        
        return $result
            ? jsonResponse('success', 'Danh sách người dùng', $result)
            : jsonResponse('error', 'Không tìm thấy danh sách người dùng!');
    }
    public function update(UpdateUserRequest $request)
    {
        $data = $request->validated();
        $result = $this->userService->update($data['id'], $data);

        if ($result) {
            $updatedUser = $this->userService->getAllUsersWithRoles()->where('id', $data['id'])->first();
            return jsonResponse('success', 'Người dùng đã được cập nhật thành công', $updatedUser);
        } else {
            return jsonResponse('error', 'Cập nhật người dùng thất bại!');
        }
    }
    public function destroy(Request $request)
    {
        $result = $this->userService->delete($request->id);

        return $result
            ? jsonResponse('success', 'Người dùng đã được xóa thành công')
            : jsonResponse('error', 'Xóa người dùng thất bại!');
    }
    public function roleService()
    {
        return app(RoleService::class);
    }


    public function getUsers()
    {
        $result = $this->userService->getCurrentUser();
        return $result 
            ? jsonResponse('success', 'Thông tin người dùng', ['user' => $result] )
            : jsonResponse('error', 'Không tìm thấy người dùng!');
    }

    public function getUserId()
    {
        $result = $this->userService->getUserId();
        return $result 
            ? jsonResponse('success', 'id người dùng', ['id' => $result] )
            : jsonResponse('error', 'Không tìm thấy người dùng!');
    }
}
