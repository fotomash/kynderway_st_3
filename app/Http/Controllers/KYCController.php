<?php

namespace App\Http\Controllers;

use App\Services\KYCService;
use Illuminate\Http\Request;

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
     */
    public function initiateBackgroundCheck(Request $request)
    {
        $request->validate([
            'consent' => 'required|accepted',
            'ssn' => 'required|string',
        ]);

        $report = $this->kycService->performBackgroundCheck($request->user());

        return response()->json([
            'report_id' => $report->id,
            'status' => 'pending',
            'estimated_completion' => now()->addDays(3),
        ]);
    }
}
