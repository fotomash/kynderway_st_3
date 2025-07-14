<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use App\Services\KYCService;

class StubKYCService extends KYCService
{
    public function __construct()
    {
        // Skip parent constructor to avoid AWS SDK dependency
        $this->checkrService = new \App\Services\CheckrService();
    }
}

class BackgroundCheckTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('phone')->nullable();
            $table->string('postal_code')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('ssn')->nullable();
            $table->string('checkr_candidate_id')->nullable();
            $table->string('background_check_report_id')->nullable();
            $table->string('background_check_status')->nullable();
            $table->timestamp('background_check_initiated_at')->nullable();
            $table->timestamps();
        });

        $this->app->instance(KYCService::class, new StubKYCService());

        config(['app.key' => 'base64:' . base64_encode(random_bytes(32))]);
        config(['services.checkr.secret' => 'test_secret']);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_background_check_can_be_initiated()
    {
        Http::fake();

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/v1/kyc/background-check', [
            'consent' => '1',
            'ssn' => '123456789',
        ]);

        $response->assertOk()->assertJson([
            'report_id' => 'rpt_stub',
            'status' => 'pending',
        ]);

        $user->refresh();
        $this->assertEquals('cand_stub', $user->checkr_candidate_id);
        $this->assertEquals('rpt_stub', $user->background_check_report_id);
        $this->assertEquals('pending', $user->background_check_status);
        $this->assertEquals('123456789', Crypt::decryptString($user->ssn));

        Http::assertSent(function ($request) {
            return $request->url() === 'https://api.checkr.com/v1/candidates'
                && $request['ssn'] === '123456789';
        });
    }

    public function test_repeated_background_check_attempt_is_rejected()
    {
        Http::fake();

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $this->postJson('/api/v1/kyc/background-check', [
            'consent' => '1',
            'ssn' => '123456789',
        ])->assertOk();

        $response = $this->postJson('/api/v1/kyc/background-check', [
            'consent' => '1',
            'ssn' => '123456789',
        ]);

        $response->assertStatus(409);
    }
}
