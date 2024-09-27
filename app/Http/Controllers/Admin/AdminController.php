<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function postlogin(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Da dang nhap',
                'redirect_url' => route('admin.dashboard')
            ]);
        }
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Thông tin đăng nhập không chính xác',
                ]);
            }
            $user = User::getByUsername($request->email);
            if (!Hash::check($request->password, $user->password, [])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password khong hop le',
                ]);
            }
            
            if ($user->role != 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không có quyền truy cập.',
                ], 403); 
            }
            $tokenResult = $user->createToken('Auth Token')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Dang nhap thanh cong',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'redirect_url' => route('admin.dashboard') 
            ]);
        } catch (ValidationException $validationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Xac thuc that bai',
                'errors' => $validationException->errors()
            ], 422);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Da co loi xay ra',
                'errors' => ['message' => $error->getMessage()]
            ], 500);
        }
    }
    
}
