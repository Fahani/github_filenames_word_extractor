<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 19:45
 */

namespace App\Tests\Service;


use App\Service\GithubClient;
use Github\Api\Repo;
use Github\Api\Repository\Commits;
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
    public function returnsAllTheCommitsInRepository()
    {
        $clientMock             = $this->prophesize(Client::class);
        $commitsApiClient       = $this->prophesize(Commits::class);
        $repositoriesApiClient  = $this->prophesize(Repo::class);
        $resultPagerMock        = $this->prophesize(ResultPager::class);

        $clientMock->authenticate(getenv('GITHUB_SECRET'), null, getenv('GITHUB_AUTH_METHOD'))
            ->shouldBeCalledTimes(1);

        $clientMock->repo()
            ->shouldBeCalledTimes(1)
            ->willReturn($repositoriesApiClient);

        $repositoriesApiClient->commits()
            ->willReturn($commitsApiClient);

        $resultPagerMock->fetchAll($commitsApiClient, "all", array("fahani", "colvin", ['sha' => 'master']))
            ->shouldBeCalledTimes(1)
            ->willReturn([
                ["sha" => "90ec51b93624438947df6704ecb8982d38454ef4"],
                ["sha" => "78a3b378fc5d7d2d4aebf6f0487bc0cbaf9c63ff"],
            ]);

        $githubClient = new GithubClient($clientMock->reveal(), $resultPagerMock->reveal());

        $commits = $githubClient->getAllCommitsInRepository("fahani", "colvin");

        $this->assertCount(2, $commits);
        $this->assertSame("90ec51b93624438947df6704ecb8982d38454ef4", $commits[0]["sha"]);
        $this->assertSame("78a3b378fc5d7d2d4aebf6f0487bc0cbaf9c63ff", $commits[1]["sha"]);
    }
}