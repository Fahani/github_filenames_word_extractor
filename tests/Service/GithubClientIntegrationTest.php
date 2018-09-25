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

    /**
     * @test
     * @throws \Exception
     */
    public function commitInformationThrowsExceptionOnEmptySHA()
    {
        $client = new Client();
        $resultPager = new ResultPager($client);
        $githubClient = new GithubClient($client, $resultPager);

        $this->expectException("Exception");

        $githubClient->getCommitInformation("fahani", "colvin", "");
    }

}