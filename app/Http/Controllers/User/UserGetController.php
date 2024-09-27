<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserGetController extends Controller
{
    public function get_user_list()
    {
        if(!Auth::check()){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!'
            ],401);
        }
        $user = Auth::user();
        if($user->role != '1'){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền thực hiện thao tác này!'
            ],403);
        }
        $get_user = User::getUser();
        return response()->json([
            'status' => 'success',
            'message' => 'Lay danh sach user thanh cong',
            'data' => $get_user
        ]);
    }
    public function get_info_by_id(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn cần đăng nhập để thực hiện thao tác này!'
            ],401);
        }
        $user = Auth::user();
        if($user->role != '1'){
            return response()->json([
               'status' => 'error',
               'message' => 'Bạn không có quyền thực hiện thao tác này!'
            ],403);
        }
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->id;
        if (!User::checkValidById($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'id khong hop le',
            ]);
        }

        $get_user = User::getUserById($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Lay danh sach user thanh cong',
            'data' => $get_user
        ]);
    }
}
