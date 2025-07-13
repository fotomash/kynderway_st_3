<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VerificationDocument;
use App\Services\KYCService;
use App\Services\CheckrService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class StubRekognitionClient
{
    public function detectText(array $params)
    {
        return [
            'TextDetections' => [
                ['Type' => 'LINE', 'DetectedText' => 'Sample'],
            ],
        ];
    }

    public function detectFaces(array $params)
    {
        return [
            'FaceDetails' => [
                ['Confidence' => 99.0],
            ],
        ];
    }
}

class LocalStubCheckrService extends CheckrService
{
    public function createCandidate(array $data)
    {
        return (object) ['id' => 'cand_stub'];
    }

    public function createReport(string $candidateId, array $options)
    {
        return (object) ['id' => 'rpt_stub', 'status' => 'pending'];
    }
}

class LocalStubKYCService extends KYCService
{
    public function __construct()
    {
        $this->checkrService = new LocalStubCheckrService();
        $this->rekognition = new StubRekognitionClient();
    }
}

class KYCControllerTest extends TestCase
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

        Schema::create('verification_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('document_type');
            $table->string('document_path');
            $table->json('verification_data')->nullable();
            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
        });

        $this->app->instance(KYCService::class, new LocalStubKYCService());

        config(['app.key' => 'base64:' . base64_encode(random_bytes(32))]);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('verification_documents');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_verify_document_creates_record()
    {
        Storage::fake('s3');

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/v1/kyc/verify-document', [
            'document' => UploadedFile::fake()->image('id.jpg'),
            'document_type' => 'passport',
        ]);

        $response->assertOk()->assertJson(['status' => 'verified']);

        $verification = VerificationDocument::first();
        $this->assertNotNull($verification);
        $this->assertEquals($user->id, $verification->user_id);
        $this->assertEquals('passport', $verification->document_type);
        $this->assertEquals('verified', $verification->status);
    }

    public function test_initiate_background_check_updates_user()
    {
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
    }
}

