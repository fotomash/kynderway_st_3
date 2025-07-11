<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s+(.*)/', $authHeader, $matches)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $matches[1];
        $payload = $this->decodeJwt($token);
        if (!$payload || empty($payload['sub'])) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user = User::find($payload['sub']);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 401);
        }

        auth()->setUser($user);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }

    private function decodeJwt(string $jwt): ?array
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return null;
        }

        [$header64, $payload64, $signature64] = $parts;
        $payload = json_decode($this->base64UrlDecode($payload64), true);
        $header = json_decode($this->base64UrlDecode($header64), true);
        if (!$payload || !$header) {
            return null;
        }

        $expected = hash_hmac('sha256', $header64 . '.' . $payload64, env('JWT_SECRET', ''), true);
        $signature = $this->base64UrlDecode($signature64);
        if (!hash_equals($expected, $signature)) {
            return null;
        }

        return $payload;
    }

    private function base64UrlDecode(string $input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $input .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }
}
