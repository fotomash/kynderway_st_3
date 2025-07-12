<?php

namespace Tests\Unit;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Http\Request;
use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_security_headers_are_added()
    {
        $middleware = new SecurityHeaders();
        $request = Request::create('/', 'GET');

        $response = $middleware->handle($request, function () {
            return response('OK');
        });

        $this->assertEquals('nosniff', $response->headers->get('X-Content-Type-Options'));
        $this->assertEquals('DENY', $response->headers->get('X-Frame-Options'));
        $this->assertEquals('1; mode=block', $response->headers->get('X-XSS-Protection'));
        $this->assertEquals('max-age=31536000; includeSubDomains', $response->headers->get('Strict-Transport-Security'));
        $this->assertEquals("default-src 'self'; img-src 'self' data:; script-src 'self'; style-src 'self' 'unsafe-inline'", $response->headers->get('Content-Security-Policy'));
        $this->assertEquals('strict-origin-when-cross-origin', $response->headers->get('Referrer-Policy'));
        $this->assertEquals('geolocation=(), microphone=()', $response->headers->get('Permissions-Policy'));
    }
}
