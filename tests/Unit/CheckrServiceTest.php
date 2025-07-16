<?php

namespace Tests\Unit;

use App\Services\CheckrService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckrServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.key' => 'base64:' . base64_encode(random_bytes(32))]);
        config(['services.checkr.secret' => 'test_secret']);
    }

    public function test_create_candidate_decrypts_ssn_and_posts_data(): void
    {
        Http::fake([
            'https://api.checkr.com/v1/candidates' => Http::response(['id' => 'cand_1'], 200),
        ]);

        $service = new CheckrService();
        $encrypted = Crypt::encryptString('123456789');
        $candidate = $service->createCandidate([
            'first_name' => 'John',
            'ssn' => $encrypted,
        ]);

        $this->assertEquals('cand_1', $candidate->id);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.checkr.com/v1/candidates'
                && $request['ssn'] === '123456789'
                && $request['first_name'] === 'John';
        });
    }

    public function test_create_report_posts_candidate_id_and_options(): void
    {
        Http::fake([
            'https://api.checkr.com/v1/reports' => Http::response(['id' => 'rpt_1', 'status' => 'pending'], 200),
        ]);

        $service = new CheckrService();
        $report = $service->createReport('cand_1', ['package' => 'pro']);

        $this->assertEquals('rpt_1', $report->id);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.checkr.com/v1/reports'
                && $request['candidate_id'] === 'cand_1'
                && $request['package'] === 'pro';
        });
    }
}
