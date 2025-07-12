<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\Clock\SystemClock;

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
        try {
            $config = Configuration::forSymmetricSigner(
                new Sha256(),
                InMemory::plainText(env('JWT_SECRET', ''))
            );

            $token = $config->parser()->parse($jwt);
            \assert($token instanceof UnencryptedToken);

            $config->validator()->assert(
                $token,
                new SignedWith($config->signer(), $config->verificationKey()),
                new StrictValidAt(new SystemClock(new \DateTimeZone('UTC')))
            );

            return $token->claims()->all();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
