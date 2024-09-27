<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class UserController extends Controller
{
    use HasApiTokens;
    public function login(Request $request)
    {
        if (Auth::check()) {
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Da dang nhap',
            //     'redirect_url' => '/',
            // ]);
            // return redirect()->route('dashboard');
            return redirect()->away('http://127.0.0.1:53293/index.html');
        }
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'username' => ['Username khong hop le'],
                ]);
            }
            $user = User::getByUsername($request->email);
            if (!Hash::check($request->password, $user->password, [])) {
                throw ValidationException::withMessages([
                    'password' => ['Password khong hop le'],
                ]);
            }
            $tokenResult = $user->createToken('Auth Token')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'Dang nhap thanh cong',
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
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
            $tokenResult = $user->createToken('Auth Token')->plainTextToken;
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
}
