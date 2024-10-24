<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class EqualTest extends TestCase
{
    public function testEqual(): void
    {
        $this->assertEquals(2, 1 + 1);
    }
}
