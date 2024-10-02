<?php

namespace Tests;

use Lithe\Support\Security\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    public function testMakeCreatesHash()
    {
        $value = 'password';
        $hash = Hash::make($value);
        
        // Verify that the generated hash is not equal to the original value
        $this->assertNotEquals($value, $hash);
        // Verify that the hash is valid for the original value
        $this->assertTrue(Hash::check($value, $hash));
    }

    public function testMakeThrowsExceptionForInvalidCost()
    {
        $this->expectException(\InvalidArgumentException::class);
        Hash::make('password', ['cost' => 3]); // Invalid cost
    }

    public function testCheckReturnsFalseForInvalidHash()
    {
        $value = 'password';
        $hash = Hash::make($value);
        
        // Verify that a wrong password does not match the hash
        $this->assertFalse(Hash::check('wrong-password', $hash));
    }

    public function testNeedsRehashReturnsTrueForDifferentCost()
    {
        $value = 'password';
        $hash = Hash::make($value, ['cost' => 10]);
        
        // Check if the hash needs to be rehashed with a different cost
        $this->assertTrue(Hash::needsRehash($hash, ['cost' => 12]));
        // Verify that the hash does not need to be rehashed with the same cost
        $this->assertFalse(Hash::needsRehash($hash, ['cost' => 10]));
    }
}
