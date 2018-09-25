<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 18:56
 */

namespace App\Service;
use App\Entity\Word;

/**
 * A service that holds an array of the Words[] used in the repository and its frequency.
 * Class WordCounter
 * @package App\Service
 */
class WordCounter
{

    /** @var Word[] $words */
    private $words;

    public function __construct()
    {
        $this->words = array();
    }

    /**
     * Returns the array with the Words
     * @return Word[]
     */
    public function getWords(): array
    {
       return $this->words;
    }

    /**
     * It adds a word to the array if the word doesn't exist. It the word exists, it increments its frequency.
     * Empty names are ignored
     * @param string $name
     * @return WordCounter
     */
    public function addWord(string $name):self
    {
        if (empty($name))
            return $this;

        if(isset($this->words[$name]))
        {
            $this->words[$name]->incrementFrequencyByOne();
        } else {
            $wordToAdd = new Word($name, 1);
            $this->words[$name] = $wordToAdd;
        }

        return $this;
    }
}