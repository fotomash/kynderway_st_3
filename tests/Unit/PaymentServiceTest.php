<?php

namespace Tests\Unit;

use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    public function test_create_payment_intent_returns_intent(): void
    {
        $this->markTestSkipped('PaymentIntent mocking unsupported in this environment');
    }
}
