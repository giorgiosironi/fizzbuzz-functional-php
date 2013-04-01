<?php
class FizzBuzz
{
    private $words;

    public function __construct()
    {
        $this->words = array(
            3 => 'fizz',
            5 => 'buzz',
        );
    }

    public function say($number)
    {
        $result = '';
        foreach ($this->words as $divisor => $word) {
            if ($this->divisible($number, $divisor)) {
                $result .= $word;
            }
        }
        if ($result) {
            return $result;
        }
        return $number;
    }

    private function divisible($number, $divisor)
    {
        return $number % $divisor == 0;
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
