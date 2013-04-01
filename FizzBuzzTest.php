<?php
class FizzBuzz
{
    public function say($number)
    {
        if ($number == 3) {
            return 'fizz';
        }
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

    public function test3IsFizz()
    {
        $fizzBuzz = new FizzBuzz();
        $this->assertEquals('fizz', $fizzBuzz->say(3));
    }
}
