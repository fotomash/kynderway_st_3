<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Exceptions\CheckrApiException;

class CheckrService
{
    protected string $baseUrl = 'https://api.checkr.com/v1/';
    protected string $secret;

    public function __construct()
    {
        $this->secret = config('services.checkr.secret');
    }

    protected function client()
    {
        return Http::withBasicAuth($this->secret, '');
    }

    /**
     * Create a candidate on Checkr
     */
    public function createCandidate(array $data)
    {
        if (isset($data['ssn'])) {
            // ssn value is expected to be encrypted when provided
            $data['ssn'] = Crypt::decryptString($data['ssn']);
        }

        try {
            $response = $this->client()->post($this->baseUrl . 'candidates', $data);
            $response->throw();

            return (object) $response->json();
        } catch (Throwable $e) {
            Log::error('Checkr candidate creation failed', [
                'message' => $e->getMessage(),
            ]);

            throw new CheckrApiException('Unable to create Checkr candidate', 0, $e);
        }
    }

    /**
     * Create a report for a candidate
     */
    public function createReport(string $candidateId, array $data)
    {
        $payload = array_merge($data, ['candidate_id' => $candidateId]);

        try {
            $response = $this->client()->post($this->baseUrl . 'reports', $payload);
            $response->throw();

            return (object) $response->json();
        } catch (Throwable $e) {
            Log::error('Checkr report creation failed', [
                'message' => $e->getMessage(),
            ]);

            throw new CheckrApiException('Unable to create Checkr report', 0, $e);
        }
    }
}
