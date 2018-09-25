<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 19:45
 */

namespace App\Tests\Service;


use App\Service\GithubClient;
use Github\Client;
use Github\ResultPager;
use PHPUnit\Framework\TestCase;

class GithubClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCallToAuthenticate()
    {
        $clientMock = $this->prophesize(Client::class);
        $resultPagerMock = $this->prophesize(ResultPager::class);

        $clientMock->authenticate(getenv('GITHUB_SECRET'), null, getenv('GITHUB_AUTH_METHOD'))
            ->shouldBeCalledTimes(1);
        new GithubClient($clientMock->reveal(), $resultPagerMock->reveal());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function commitInformationThrowsExceptionOnEmptySHA()
    {
        $clientMock = $this->prophesize(Client::class);
        $resultPagerMock = $this->prophesize(ResultPager::class);

        $this->expectException("Exception");

        $githubClient = new GithubClient($clientMock->reveal(), $resultPagerMock->reveal());

        $githubClient->getCommitInformation("user", "repo", "");
    }
}