<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Da dang nhap',
            //     'redirect_url' => '/',
            // ]);
            return redirect()->route('dashboard');
            // return redirect()->away('http://127.0.0.1:53293/index.html');
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
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mật khẩu không hợp lệ',
                ]);
            }

            $existingToken = $user->tokens->first();
            $check_token = User::getByUsername($request->email);
            if ($existingToken && $check_token->remember_token != null) {
                $get_user = User::getByUsername($request->email);
                $tokenResult = $get_user->remember_token;
            } else {
                $tokenResult = $user->createToken('authToken')->plainTextToken;
                $save_token = User::updateToken($request->email, $tokenResult);
                if (!$save_token) {
                    throw new \Exception('Lỗi truy vấn cơ sở dữ liệu');
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Đăng nhập thành công',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'redirect_url' => route('dashboard')
            ]);
        } catch (ValidationException $validationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Xác thực thất bại',
                'errors' => $validationException->errors()
            ], 422);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra',
                'errors' => ['message' => $error->getMessage()]
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|unique:users,email',
                'password' => 'required|min:8',
                'repassword' => 'required|min:8',
                'name' => 'required',
                'phone' => 'required|unique:users',
                'address' => 'required',
            ]);
            if (User::checkUsername($request->email)) {
                throw ValidationException::withMessages([
                    'email' => ['Email da ton tai'],
                ]);
            }
            if ($request->password != $request->repassword) {
                throw ValidationException::withMessages([
                    'password' => ['Password khong giong nhau'],
                ]);
            }
            $user = User::createUser($request->email, $request->name, Hash::make($request->password), $request->address, $request->phone);
            if (!$user) {
                throw ValidationException::withMessages([
                    'create' => ['Tao tai khoan that bai'],
                ]);
            }
            Auth::login($user);
            $tokenResult = $user->createToken($user->id)->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Dang ky thanh cong',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Co loi xay ra',
                'errors' => ['message' => $e->getMessage()]
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();
            $user->remember_token = null;
            $user->save();

            return response()->json(['message' => 'Đã đăng xuất thành công']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra khi đăng xuất', 'message' => $e->getMessage()], 500);
        }
    }
}
