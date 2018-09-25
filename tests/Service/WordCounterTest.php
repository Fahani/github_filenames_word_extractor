<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 18:47
 */

namespace App\Tests\Service;


use App\Service\WordCounter;
use PHPUnit\Framework\TestCase;

class WordCounterTest extends TestCase
{
    /**
     * @test
     */
    public function getAndSetWordsWorksAsExpected()
    {
        $wordCounter = new WordCounter();

        $this->assertEmpty($wordCounter->getWords());

        $wordCounter->addWord("");

        $this->assertEmpty($wordCounter->getWords());

        $wordCounter->addWord("File");

        $this->assertCount(1, $wordCounter->getWords());
        $this->assertSame(1, $wordCounter->getWords()["File"]->getFrequency());
        $this->assertSame("File", $wordCounter->getWords()["File"]->getName());

        $wordCounter->addWord("File");

        $this->assertCount(1, $wordCounter->getWords());
        $this->assertSame(2, $wordCounter->getWords()["File"]->getFrequency());
        $this->assertSame("File", $wordCounter->getWords()["File"]->getName());

        $wordCounter->addWord("Six");

        $this->assertCount(2, $wordCounter->getWords());
        $this->assertSame(2, $wordCounter->getWords()["File"]->getFrequency());
        $this->assertSame("File", $wordCounter->getWords()["File"]->getName());
        $this->assertSame(1, $wordCounter->getWords()["Six"]->getFrequency());
        $this->assertSame("Six", $wordCounter->getWords()["Six"]->getName());
    }
}