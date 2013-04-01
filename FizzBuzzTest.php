<?php
class FizzBuzz
{
    public function say($number)
    {
        if ($number % 3 == 0) {
            return 'fizz';
        }
        return $number;
    }
}

class FizzBuzzTest extends PHPUnit_Framework_TestCase
{
    public static function numberToResult()
    {
        return array(
            array(1, 1),
            array(3, 'fizz'),
            array(6, 'fizz'),
        );
    }

    /**
     * @dataProvider numberToResult
     */
    public function testNumberIsMappedToResult($number, $result)
    {
        $fizzBuzz = new FizzBuzz();
        $this->assertEquals($result, $fizzBuzz->say($number));
    }
}
