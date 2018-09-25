<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 20:24
 */

namespace App\Tests\Service;


use App\Service\GithubClient;
use Github\Client;
use Github\ResultPager;
use PHPUnit\Framework\TestCase;

class GithubClientIntegrationTest extends TestCase
{

    private $githubClient;


    protected function setUp()
    {
        $client = new Client();
        $resultPager = new ResultPager($client);
        $this->githubClient = new GithubClient($client, $resultPager);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function commitInformationThrowsExceptionOnEmptySHA()
    {
        $this->expectException("Exception");

        $this->githubClient->getCommitInformation("fahani", "colvin", "");
    }

    /**
     * @test
     * @throws \Exception
     */
    public function commitInformationReturnsExpectedData()
    {
        $commitInformation = $this->githubClient->getCommitInformation("fahani", "colvin", "90ec51b93624438947df6704ecb8982d38454ef4");

        $this->assertSame($commitInformation["sha"], "90ec51b93624438947df6704ecb8982d38454ef4");
        $this->assertSame($commitInformation["files"][0]["filename"], "another_folder/FileSix.php");
    }


}