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
                $result = $result->append($word);
            }
        }
        return Maybe::from($result, $number);
    }

    private function divisible($number, $divisor)
    {
        return $number % $divisor == 0;
    }
}

class Maybe
{
    public static function from($just, $default)
    {
        if ((string) $just) {
            return new self($just);
        }
        return new self($default);
    }

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
