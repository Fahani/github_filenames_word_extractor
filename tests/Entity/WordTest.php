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

    /**
     * @test
     */
    public function checkNameAndFrequencyPersist()
    {
        $word = new Word("Main", 10);

        $this->assertSame(10, $word->getFrequency());
        $this->assertSame("Main", $word->getName());
    }

    /**
     * @test
     */
    public function incrementFrequencyAndNamePersists()
    {
        $word = new Word("Main", 10);

        $this->assertSame(10, $word->getFrequency());

        $word = $word->incrementFrequencyByOne();

        $this->assertSame(11, $word->getFrequency());
        $this->assertSame("Main", $word->getName());
    }
}