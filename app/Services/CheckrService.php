<?php

namespace App\Services;

class CheckrService
{
    /**
     * Create a candidate on Checkr.
     */
    public function createCandidate(array $data)
    {
        // Stub implementation. Integrate with Checkr API in production.
        return (object) ['id' => 'cand_stub'];
    }

    /**
     * Create a report for a candidate.
     */
    public function createReport(string $candidateId, array $options)
    {
        // Stub implementation. Integrate with Checkr API in production.
        return (object) ['id' => 'rpt_stub', 'status' => 'pending'];
    }
}

