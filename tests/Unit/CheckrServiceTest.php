<?php

namespace Tests\Unit;

use App\Exceptions\CheckrApiException;
use App\Services\CheckrService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CheckrServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['services.checkr.secret' => 'test_secret']);
    }

    public function test_create_candidate_success()
    {
        Http::fake([
            'https://api.checkr.com/v1/candidates' => Http::response(['id' => 'cand_1'], 200),
        ]);

        $service = new CheckrService();
        $candidate = $service->createCandidate(['first_name' => 'Test']);

        $this->assertEquals('cand_1', $candidate->id);
    }

    public function test_create_candidate_failure_throws_exception_and_logs()
    {
        Http::fake([
            'https://api.checkr.com/v1/candidates' => Http::response(null, 500),
        ]);
        Log::spy();

        $service = new CheckrService();

        $this->expectException(CheckrApiException::class);
        try {
            $service->createCandidate(['first_name' => 'Test']);
        } finally {
            Log::shouldHaveReceived('error');
        }
    }

    public function test_create_report_success()
    {
        Http::fake([
            'https://api.checkr.com/v1/reports' => Http::response(['id' => 'rpt_1'], 200),
        ]);

        $service = new CheckrService();
        $report = $service->createReport('cand_1', ['package' => 'basic']);

        $this->assertEquals('rpt_1', $report->id);
    }

    public function test_create_report_failure_throws_exception_and_logs()
    {
        Http::fake([
            'https://api.checkr.com/v1/reports' => Http::response(null, 500),
        ]);
        Log::spy();

        $service = new CheckrService();

        $this->expectException(CheckrApiException::class);
        try {
            $service->createReport('cand_1', ['package' => 'basic']);
        } finally {
            Log::shouldHaveReceived('error');
        }
    }
}
