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

    /**
     * @OA\Post(
     *     path="/api/browse/nannies/{id}/unlock",
     *     summary="Unlock nanny profile",
     *     tags={"Credits"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the nanny",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful unlock"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
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

        if (!$this->credits->hasEnoughCredits($user)) {
            return response()->json(['message' => 'Insufficient credits'], 400);
        }

        $this->credits->deductCredits($user);

        return response()->json([
            'success' => true,
            'nanny' => $nanny,
            'remaining_credits' => $user->credits,
        ]);
    }
}
