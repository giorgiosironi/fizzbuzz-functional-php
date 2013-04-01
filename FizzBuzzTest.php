<?php
class FizzBuzz
{
    public function say($number)
    {
        $result = '';
        if ($number % 3 == 0) {
            $result .= 'fizz';
        }
        if ($number % 5 == 0) {
            $result .= 'buzz';
        }
        if ($result) {
            return $result;
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
            array(5, 'buzz'),
            array(6, 'fizz'),
            array(10, 'buzz'),
            array(15, 'fizzbuzz'),
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
