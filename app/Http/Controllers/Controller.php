<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function someFunction()
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn chưa đăng nhập',
            ], 401);
        }

        $email = Auth::user();

        return response()->json([
            'status' => 'success',
            'message' => 'Đã đăng nhập thành công',
            'email' => $email,
        ]);
    }
    public function checkSession(Request $request)
    {
        if ($request->session()->has('user_id')) {
            $userId = $request->session()->get('user_id');

            return response()->json([
                'status' => 'success',
                'message' => 'Session tồn tại',
                'user_id' => $userId
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Session không tồn tại'
            ]);
        }
    }
}
