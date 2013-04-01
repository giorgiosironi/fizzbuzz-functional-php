<?php
class FizzBuzz
{
    public function say($number)
    {
        $result = new Result($number);
        if ($this->divisible($number, 3)) {
            $result->addWord('fizz');
        }
        if ($this->divisible($number, 5)) {
            $result->addWord('buzz');
        }
        return $result;
    }

    private function divisible($number, $divisor)
    {
        return $number % $divisor == 0;
    }
}

class Result
{
    private $result;
    private $words = array();

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function addWord($word)
    {
        $this->words[] = $word;
    }

    public function __toString()
    {
        if ($this->words) {
            return implode('', $this->words);
        }
        return (string) $this->number;
    }
}

class FizzBuzzTest extends PHPUnit_Framework_TestCase
{
    public static function numberToResult()
    {
        return array(
            array(1, '1'),
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
