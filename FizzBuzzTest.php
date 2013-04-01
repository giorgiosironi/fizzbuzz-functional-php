<?php
class FizzBuzz
{
    private $words;

    public function __construct()
    {
        $this->words = array(
            3 => Words::single('fizz'),
            5 => Words::single('buzz'),
            7 => Words::single('bang'),
        );
        $this->divisors = array_keys($this->words);
    }

    public function say($number)
    {
        $words = array_map(function($divisor) use ($number) {
            return $this->wordFor($number, $divisor);
        }, $this->divisors);
        return reduce_objects($words, 'append')->getOr($number);
    }

    private function wordFor($number, $divisor)
    {
        if ($number % $divisor == 0) {
            return Maybe::just($this->words[$divisor]);
        }
        return Maybe::nothing();
    }
}

interface Monoid
{
    /**
     * @return Monoid
     */
    public function append($another);
}

function reduce_objects($array, $methodName)
{
    return array_reduce($array, function($one, $two) use ($methodName) {
        return $one->$methodName($two);
    }, Maybe::nothing());
}

class Maybe implements Monoid
{
    public static function just($value)
    {
        return new self($value);
    }

    public static function nothing()
    {
        return new self(null);
    }

    public function getOr($default)
    {
        if ($this->value !== null) {
            return $this->value;
        }
        return $default;
    }

    private $value;

    private function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function append(/*Maybe*/ $another)
    {
        if ($this->value === null) {
            return $another;
        }
        if ($another->value === null) {
            return $this;
        }
        return Maybe::just($this->value->append($another->value));
    }
}

/**
 * A Monoid over ('', .)
 */
class Words implements Monoid
{
    private $words = array();

    public static function identity()
    {
        return new self(array());
    }

    public function single($word)
    {
        return new self(array($word));
    }

    private function __construct($singleWord)
    {
        $this->words = $singleWord;
    }

    public function append(/*Words*/ $words)
    {
        return new self(array_merge($this->words, $words->words));
    }

    public function __toString()
    {
        return implode('', $this->words);
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
            array(3*5*7, 'fizzbuzzbang'),
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
