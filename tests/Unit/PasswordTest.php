<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    private $pattern = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
    private const TEST_CASES = [
        [
            "password" => "Password4",
            "result" => true
        ],
        [
            "password" => "password4",
            "result" => false
        ],
        [
            "password" => "Pass45",
            "result" => false
        ],
        [
            "password" => "password",
            "result" => false
        ],
        [
            "password" => "1234567",
            "result" => false
        ],
        [
            "password" => "Password 4",
            "result" => false
        ],
        [
            "password" => "Password4*",
            "result" => true
        ],
        [
            "password" => "PASSWORD4",
            "result" => false
        ],
        [
            "password" => "/*-+-*9",
            "result" => false
        ],
    ];
    
    public function testPasswordRegex(): void
    {
       
        foreach (self::TEST_CASES as $test) {
            
            $result = $this->match($test["password"]);
            $this->assertEquals($test["result"],$result);
            
        }
    }

    public function match($password)
    {
        return preg_match($this->pattern, $password) === 1;
    }
}
