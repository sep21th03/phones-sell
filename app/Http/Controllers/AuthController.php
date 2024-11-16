<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\TransientToken;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use Illuminate\Support\Str;

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
            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($request->name) . '&background=random';

            $user = User::createUser(
                $request->email,
                $request->name,
                Hash::make($request->password),
                $request->address,
                $request->phone,
                $avatarUrl
            );
            $user->assignRole('member');
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

            if ($user) {
                if (Auth::guard('sanctum')->check()) {
                    $accessToken = $user->currentAccessToken();

                    if (!($accessToken instanceof TransientToken)) {
                        $accessToken->delete();
                    }
                } else {
                    Auth::logout();
                }

                $user->remember_token = null;
                $user->save();
            }

            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return response()->json([
                'message' => 'Đã đăng xuất thành công',
                'redirect' => route('auth.login')
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra khi đăng xuất', 'message' => $e->getMessage()], 500);
        }
    }

    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
                ->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Không thể kết nối với Google. Vui lòng thử lại sau.');
        }
    }



    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]
            );

            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
                $user->save();
            }

            // Đăng nhập user
            Auth::login($user, true);

            return redirect()->intended('/dashboard')
                ->with('success', 'Đăng nhập thành công!');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Đã có lỗi xảy ra trong quá trình đăng nhập. Vui lòng thử lại.');
        }
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        if (!Hash::check($data['current_password'], $user->password)) {
            return jsonResponse(2, message: "Mật khẩu cũ không chính xác.");
        }
        $user->update(['password' => Hash::make($data['password'])]);
        if ($user) {
            $user->tokens()->delete();
            return jsonResponse(0, message: "Thay đổi mật khẩu thành công.");
        } else {
            return jsonResponse(2, message: "Có lỗi xảy ra, vui lòng thử lại sau.");
        }
    }
    function sendResetLinkEmail(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return jsonResponse(1, message: "Không tìm thấy người dùng");
        }
        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);
        \Log::info($status);

        if ($status == Password::RESET_LINK_SENT) {
            return jsonResponse(0, message: "Yêu cầu đã được gửi");
        }
    }
    function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'token' => 'required',
            "password_confirmation" => 'required|min:6',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return jsonResponse($status === Password::PASSWORD_RESET ? 0 : 1, $status);
    }
}
