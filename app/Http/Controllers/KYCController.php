<?php

namespace App\Http\Controllers;

use App\Services\KYCService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class KYCController extends Controller
{
    private $kycService;

    public function __construct(KYCService $kycService)
    {
        $this->kycService = $kycService;
    }

    /**
     * @OA\Post(
     *     path="/api/kyc/verify-document",
     *     summary="Upload and verify identity document",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="document", type="file"),
     *                 @OA\Property(property="document_type", type="string", enum={"passport", "drivers_license", "national_id"})
     *             )
     *         )
     *     )
     * )
     */
    public function verifyDocument(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'document_type' => 'required|in:passport,drivers_license,national_id',
        ]);

        $path = $request->file('document')->store('kyc-documents', 's3');

        $verification = $this->kycService->verifyIdentityDocument(
            $request->user(),
            $path,
            $request->document_type
        );

        return response()->json([
            'status' => $verification->status,
            'message' => 'Document uploaded and verification in progress',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/kyc/background-check",
     *     summary="Initiate background check"
     * )
     *
     * The provided SSN is encrypted and stored on the authenticated user.
     * When {@see KYCService::performBackgroundCheck()} triggers the Checkr API
     * the encrypted SSN is decrypted by {@see CheckrService} before sending it
     * to the external service.
     */
    public function initiateBackgroundCheck(Request $request)
    {
        $request->validate([
            'consent' => 'required|accepted',
            'ssn' => 'required|string',
        ]);
        $user = $request->user();

        if ($user->background_check_status === 'pending') {
            return response()->json(['message' => 'Background check already initiated'], 409);
        }

        $user->ssn = Crypt::encryptString($request->input('ssn'));
        $user->save();

        $report = $this->kycService->performBackgroundCheck($user);

        return response()->json([
            'report_id' => $report->id,
            'status' => $report->status ?? 'pending',
            'estimated_completion' => now()->addDays(3),
        ]);
    }
}
