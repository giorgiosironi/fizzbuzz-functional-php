<?php
class FizzBuzz
{
    private $words;

    public function __construct()
    {
        $this->words = array(
            3 => WordsMonoid::single('fizz'),
            5 => WordsMonoid::single('buzz'),
        );
    }

    public function say($number)
    {
        $result = Maybe::wrap(WordsMonoid::identity());
        foreach ($this->words as $divisor => $word) {
                // use Maybe for these values
                // but first check its implementation is good
            $word = $this->divisible($number, $divisor, $word);
            $result = $result->append($word);
        }
        return $result->getOr($number);
    }

    private function divisible($number, $divisor, $word)
    {
        if ($number % $divisor == 0) {
            return Maybe::just($word);
        }
        return Maybe::nothing();
    }
}

class Maybe
{
    public static function just($value)
    {
        return new self($value);
    }

    public static function nothing()
    {
        return new self(null);
    }

    public static function wrap($value)
    {
        if ((string) $value) {
            return self::just($value);
        }
        return self::nothing();
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

    public function append(Maybe $another)
    {
        if ($this->value === null) {
            return $another;
        }
        if ($another->value === null) {
            return $this;
        }
        return Maybe::wrap($this->value->append($another->value));
    }
}

class WordsMonoid
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

    public function append($word)
    {
        return new self(array_merge($this->words, $word->words));
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
