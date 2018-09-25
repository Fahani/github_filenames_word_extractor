<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 20:37
 */

namespace App\Tests\Helper;


use App\Helper\GithubInformationExtractor;
use PHPUnit\Framework\TestCase;

class GithubInformationExtractorTest extends TestCase
{

    /**
     * @test
     */
    public function getFileNamesFromGithubCommitInformation()
    {
        $commitInformation = [];

        $fileNames = GithubInformationExtractor::getFileNameInCommitInformation($commitInformation);

        $this->assertEmpty($fileNames);

        $commitInformation = [
            "files" => []
        ];

        $fileNames = GithubInformationExtractor::getFileNameInCommitInformation($commitInformation);

        $this->assertEmpty($fileNames);

        $commitInformation = [
            "files" => [
                ["filename" => "another_folder/FileSix.php"]
            ]
        ];

        $fileNames = GithubInformationExtractor::getFileNameInCommitInformation($commitInformation);

        $this->assertCount(1, $fileNames);
        $this->assertSame("another_folder/FileSix.php", $fileNames[0]);

        $commitInformation = [
            "files" => [
                ["filename" => "another_folder/FileSix.php"],
                ["filename" => "another_folder/FileFive.php"]
            ]
        ];

        $fileNames = GithubInformationExtractor::getFileNameInCommitInformation($commitInformation);

        $this->assertCount(2, $fileNames);
        $this->assertSame("another_folder/FileSix.php", $fileNames[0]);
        $this->assertSame("another_folder/FileFive.php", $fileNames[1]);
    }

}