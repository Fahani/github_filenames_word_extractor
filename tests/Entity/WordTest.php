<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 18:16
 */

namespace App\Tests\Entity;


use App\Entity\Word;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    private $word;

    protected function setUp()
    {
        $this->word = new Word("Main", 10);;
    }


    /**
     * @test
     */
    public function checkNameAndFrequencyPersist()
    {
        $this->assertSame(10, $this->word->getFrequency());
        $this->assertSame("Main", $this->word->getName());
    }

    /**
     * @test
     */
    public function incrementFrequencyAndNamePersists()
    {
        $this->assertSame(10, $this->word->getFrequency());

        $this->word = $this->word->incrementFrequencyByOne();

        $this->assertSame(11, $this->word->getFrequency());
        $this->assertSame("Main", $this->word->getName());
    }
}