<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;

class ValidateApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-Key');

        if (! $apiKey) {
            return response()->json(['error' => 'API key required'], 401);
        }

        $key = ApiKey::where('key', $apiKey)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (! $key) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        $key->update(['last_used_at' => now()]);

        return $next($request);
    }
}
