<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RootRedirectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });

        Route::get('/', function () {
            return auth()->check()
                ? redirect(RouteServiceProvider::HOME)
                : redirect('/search-jobs');
        })->name('landing');
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_guest_is_redirected_to_search_jobs()
    {
        $response = $this->get('/');

        $response->assertRedirect('/search-jobs');
    }

    public function test_authenticated_user_is_redirected_to_home()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
