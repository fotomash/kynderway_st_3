<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CreditService;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    private CreditService $credits;

    public function __construct(CreditService $credits)
    {
        $this->credits = $credits;
    }

    public function unlockNanny(Request $request, $id)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $nanny = User::find($id);
        if (!$nanny) {
            return response()->json(['message' => 'Nanny not found'], 404);
        }

        if (!$this->credits->hasEnoughCredits($user, 3)) {
            return response()->json(['message' => 'Insufficient credits'], 400);
        }

        $this->credits->deductCredits($user, 3);

        return response()->json([
            'success' => true,
            'nanny' => $nanny,
            'remaining_credits' => optional($user->credits()->first())->balance ?? 0,
        ]);
    }
}
