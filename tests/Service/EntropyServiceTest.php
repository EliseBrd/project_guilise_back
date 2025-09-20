<?php

namespace App\Tests\Service;

use App\Service\EntropyService;
use PHPUnit\Framework\TestCase;

class EntropyServiceTest extends TestCase
{
    private EntropyService $service;

    protected function setUp(): void
    {
        $this->service = new EntropyService();
    }

    public function testCalculateEntropy()
    {
        $this->assertEquals(0.0, $this->service->calculateEntropy(''));
        $this->assertGreaterThan(3.0, $this->service->calculateEntropy('abcABC123!@#'));
        $this->assertEquals(0.0, $this->service->calculateEntropy(str_repeat('a', 10)));
    }

    public function testCalculateTotalEntropy()
    {
        $this->assertEquals(0.0, $this->service->calculateTotalEntropy(''));
        $this->assertGreaterThan(36.0, $this->service->calculateTotalEntropy('abcABC123!@#')); // 12 caractères * >3 bits
        $this->assertEquals(0.0, $this->service->calculateTotalEntropy(str_repeat('a', 10)));
    }

    public function testCalculateFrequency()
    {
        $freq = $this->service->calculateFrequency('aa');
        $this->assertEquals(1.0, $freq['a']);
        $this->assertEquals(0.0, $freq['b']);
    }

    public function testCalculateVariance()
    {
        $this->assertLessThan(0.1, $this->service->calculateVariance('aaaa'));
        $this->assertGreaterThan(0.0, $this->service->calculateVariance('abcd'));
    }

    public function testCheckEntropy()
    {
        $this->assertFalse($this->service->checkEntropy('aaaa', 1.0));
        $this->assertTrue($this->service->checkEntropy('abcd', 1.0));
    }
}
