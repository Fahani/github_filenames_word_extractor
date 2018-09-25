<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 20:32
 */

namespace App\Tests\Helper;


use App\Helper\FilenameWordSplitter;
use PHPUnit\Framework\TestCase;

class FilenameWordSplitterTest extends TestCase
{

    /**
     * @test
     */
    public function filenameIsSplitIntoWords()
    {
        $words = FilenameWordSplitter::filenameToWords("", "php");

        $this->assertEmpty($words);

        $words = FilenameWordSplitter::filenameToWords("another_folder/FileSix.php", "php");

        $this->assertCount(2, $words);
        $this->assertSame("File", $words[1]);
        $this->assertSame("Six", $words[2]);

        $words = FilenameWordSplitter::filenameToWords("another_folder/FileSix.php", ".go");

        $this->assertEmpty($words);
    }
}