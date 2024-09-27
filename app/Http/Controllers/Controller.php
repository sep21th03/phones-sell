<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

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

    $user = Auth::user();

    return response()->json([
        'status' => 'success',
        'message' => 'Đã đăng nhập',
        'user' => $user,
    ]);
}

}
