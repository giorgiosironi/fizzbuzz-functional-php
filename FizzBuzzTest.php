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
        $result = WordsMonoid::identity();
        foreach ($this->words as $divisor => $word) {
            if ($this->divisible($number, $divisor)) {
                // use Maybe for these values
                // but first check its implementation is good
                $result = $result->append($word);
            }
        }
        if (((string) $result) != '') {
            $result = Maybe::just($result);
        } else {
            $result = Maybe::nothing();
        }
        return $result->getOr($number);
    }

    private function divisible($number, $divisor)
    {
        return $number % $divisor == 0;
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

    public function append(WordsMonoid $word)
    {
        return new self(array_merge($this->words, $word->words));
    }

    public function __toString()
    {
        if ($this->words) {
            return implode('', $this->words);
        }
        return '';
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
