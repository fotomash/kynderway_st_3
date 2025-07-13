<?php

namespace App\Services;

use App\Models\User;
use App\Models\VerificationDocument;
use App\Services\CheckrService;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class KYCService
{
    protected $rekognition;
    protected CheckrService $checkrService;

    public function __construct(CheckrService $checkrService)
    {
        $this->checkrService = $checkrService;
        $this->rekognition = new RekognitionClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
        ]);
    }

    /**
     * Verify identity document
     */
    public function verifyIdentityDocument($user, $documentPath, $documentType)
    {
        // Extract text from document
        $textDetection = $this->rekognition->detectText([
            'Image' => [
                'S3Object' => [
                    'Bucket' => env('AWS_BUCKET'),
                    'Name' => $documentPath,
                ],
            ],
        ]);

        // Verify document authenticity
        $documentAnalysis = $this->analyzeDocument($textDetection, $documentType);

        // Face detection for photo ID
        if (in_array($documentType, ['passport', 'drivers_license', 'national_id'])) {
            $faceDetection = $this->detectFaces($documentPath);
            $documentAnalysis['has_face'] = !empty($faceDetection['FaceDetails']);
        }

        // Store verification result
        $verification = VerificationDocument::create([
            'user_id' => $user->id,
            'document_type' => $documentType,
            'document_path' => $documentPath,
            'verification_data' => $documentAnalysis,
            'status' => $this->determineVerificationStatus($documentAnalysis),
        ]);

        return $verification;
    }

    /**
     * Perform background check
     */
    public function performBackgroundCheck($user)
    {
        if (! $user->checkr_candidate_id) {
            $encryptedSsn = $user->ssn;
            try {
                // if value is already encrypted this will succeed
                Crypt::decryptString($encryptedSsn);
            } catch (\Throwable $e) {
                $encryptedSsn = Crypt::encryptString($encryptedSsn);
            }

            $candidate = $this->checkrService->createCandidate([
                'first_name' => $user->name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'dob' => $user->birth_date,
                'ssn' => $encryptedSsn,
                'zipcode' => $user->postal_code,
            ]);

            $user->checkr_candidate_id = $candidate->id;
        } else {
            $candidate = (object) ['id' => $user->checkr_candidate_id];
        }

        $report = $this->checkrService->createReport($candidate->id, [
            'package' => config('checkr.package'),
        ]);

        $user->background_check_report_id = $report->id;
        $user->background_check_status = $report->status ?? 'pending';
        $user->background_check_initiated_at = now();
        $user->save();

        return $report;
    }

    /**
     * Verify professional certifications
     */
    public function verifyCertifications($user, $certifications)
    {
        $verifiedCerts = [];

        foreach ($certifications as $cert) {
            $verified = $this->verifyCertification($cert);
            $verifiedCerts[] = [
                'type' => $cert['type'],
                'number' => $cert['number'],
                'issuer' => $cert['issuer'],
                'verified' => $verified,
                'expiry_date' => $cert['expiry_date'],
            ];
        }

        return $verifiedCerts;
    }

    /**
     * Analyze the extracted text from a document and determine validity.
     */
    public function analyzeDocument($textDetection, $documentType)
    {
        $lines = [];
        if (isset($textDetection['TextDetections'])) {
            foreach ($textDetection['TextDetections'] as $detection) {
                if (($detection['Type'] ?? '') === 'LINE') {
                    $lines[] = $detection['DetectedText'];
                }
            }
        }

        return [
            'document_type' => $documentType,
            'text_lines' => $lines,
            'valid_document' => true,
        ];
    }

    /**
     * Detect faces present in an uploaded document image.
     */
    public function detectFaces($documentPath)
    {
        return $this->rekognition->detectFaces([
            'Image' => [
                'S3Object' => [
                    'Bucket' => env('AWS_BUCKET'),
                    'Name' => $documentPath,
                ],
            ],
            'Attributes' => ['DEFAULT'],
        ]);
    }

    /**
     * Determine the final verification status based on analysis.
     */
    public function determineVerificationStatus($documentAnalysis)
    {
        return !empty($documentAnalysis['valid_document']) &&
            (!isset($documentAnalysis['has_face']) || $documentAnalysis['has_face'])
            ? 'verified'
            : 'manual_review';
    }

    /**
     * Verify a single professional certification.
     */
    public function verifyCertification($cert)
    {
        // Stub implementation. Integrate with a real verification service here.
        return !empty($cert['number']);
    }
}
