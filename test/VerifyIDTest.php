<?php

use PHPUnit\Framework\TestCase;
use VerifyID\VerifyID;

class VerifyIDTest extends TestCase
{
    public function testClassInstantiates()
    {
        $sdk = new VerifyID('dummy-key');
        $this->assertInstanceOf(VerifyID::class, $sdk);
    }
}
