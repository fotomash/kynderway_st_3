<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\CheckrService;
use App\Services\KYCService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

class KYCServiceTest extends TestCase
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
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('users');
        Mockery::close();
        parent::tearDown();
    }

    public function test_perform_background_check_creates_candidate_and_report(): void
    {
        $user = User::factory()->create();

        $checkr = Mockery::mock(CheckrService::class);
        $checkr->shouldReceive('createCandidate')
            ->once()
            ->andReturn((object) ['id' => 'cand_x']);
        $checkr->shouldReceive('createReport')
            ->with('cand_x', ['package' => 'childcare_pro'])
            ->once()
            ->andReturn((object) ['id' => 'rpt_x', 'status' => 'pending']);

        $service = new class($checkr) extends KYCService {
            public function __construct(CheckrService $service)
            {
                $this->checkrService = $service;
            }
        };
        $report = $service->performBackgroundCheck($user);

        $this->assertEquals('rpt_x', $report->id);
        $this->assertEquals('cand_x', $user->checkr_candidate_id);
        $this->assertEquals('pending', $user->background_check_status);
    }
}
