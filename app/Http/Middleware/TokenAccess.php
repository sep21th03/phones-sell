<?php
namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Closure;
class TokenAccess
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);

            if (!$accessToken) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $request->user = $accessToken->tokenable; 
        }

        return $next($request);
    }
}
