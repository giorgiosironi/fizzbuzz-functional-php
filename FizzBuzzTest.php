<?php
class FizzBuzz
{
    public function say($number)
    {
        return $number;
    }
}

class FizzBuzzTest extends PHPUnit_Framework_TestCase
{
    public function test1Is1()
    {
        $fizzBuzz = new FizzBuzz();
        $this->assertEquals(1, $fizzBuzz->say(1));
    }
}
