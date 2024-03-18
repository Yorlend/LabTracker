<?php

namespace App\Tests;
use PHPUnit\Framework\TestCase;


class MockTest extends TestCase
{
    public function test_mock(): void
    {
        $this->assertSame("", "");
    }
}