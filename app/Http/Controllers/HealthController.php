<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HealthController extends Controller
{
    public function __invoke()
    {
        try {
            DB::connection()->select('SELECT 1');
            $db = true;
        } catch (\Throwable $e) {
            $db = false;
        }

        return response()->json([
            'status' => 'ok',
            'database' => $db ? 'up' : 'down',
        ]);
    }
}
