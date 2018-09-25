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

    private $clientMock;
    private $resultPagerMock;

    protected function setUp()
    {
        $this->clientMock = $this->prophesize(Client::class);
        $this->resultPagerMock = $this->prophesize(ResultPager::class);
    }

    /**
     * @test
     */
    public function shouldCallToAuthenticate()
    {
        $this->clientMock->authenticate(getenv('GITHUB_SECRET'), null, getenv('GITHUB_AUTH_METHOD'))
            ->shouldBeCalledTimes(1);
        new GithubClient($this->clientMock->reveal(), $this->resultPagerMock->reveal());
    }

    /**
     * @test
     * @throws \Exception
     */
    public function returnsAllTheCommitsInRepository()
    {
        $commitsApiClient       = $this->prophesize(Commits::class);
        $repositoriesApiClient  = $this->prophesize(Repo::class);

        $this->clientMock->authenticate(getenv('GITHUB_SECRET'), null, getenv('GITHUB_AUTH_METHOD'))
            ->shouldBeCalledTimes(1);

        $this->clientMock->repo()
            ->shouldBeCalledTimes(1)
            ->willReturn($repositoriesApiClient);

        $repositoriesApiClient->commits()
            ->willReturn($commitsApiClient);

        $this->resultPagerMock->fetchAll($commitsApiClient, "all", array("fahani", "colvin", ['sha' => 'master']))
            ->shouldBeCalledTimes(1)
            ->willReturn([
                ["sha" => "90ec51b93624438947df6704ecb8982d38454ef4"],
                ["sha" => "78a3b378fc5d7d2d4aebf6f0487bc0cbaf9c63ff"],
            ]);

        $githubClient = new GithubClient($this->clientMock->reveal(), $this->resultPagerMock->reveal());

        $commits = $githubClient->getAllCommitsInRepository("fahani", "colvin");

        $this->assertCount(2, $commits);
        $this->assertSame("90ec51b93624438947df6704ecb8982d38454ef4", $commits[0]["sha"]);
        $this->assertSame("78a3b378fc5d7d2d4aebf6f0487bc0cbaf9c63ff", $commits[1]["sha"]);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function commitInformationReturnsExpectedData()
    {
        $commitsMock    = $this->prophesize(Commits::class);
        $repoMock       = $this->prophesize(Repo::class);

        $repoMock->commits()
            ->willReturn($commitsMock);

        $this->clientMock->authenticate(getenv('GITHUB_SECRET'), null, getenv('GITHUB_AUTH_METHOD'))
            ->shouldBeCalledTimes(1);

        $this->clientMock->api("repo")
            ->shouldBeCalledTimes(1)
            ->willReturn($repoMock);

        $commitsMock->show("fahani", "colvin", "90ec51b93624438947df6704ecb8982d38454ef4")
            ->willReturn([
                "sha" => "90ec51b93624438947df6704ecb8982d38454ef4",
                "files" => [
                    "filename" => "another_folder/FileSix.php",
                ]
            ]);


        $githubClient = new GithubClient($this->clientMock->reveal(), $this->resultPagerMock->reveal());

        $commitInformation = $githubClient->getCommitInformation("fahani", "colvin", "90ec51b93624438947df6704ecb8982d38454ef4");

        $this->assertSame($commitInformation["sha"], "90ec51b93624438947df6704ecb8982d38454ef4");
        $this->assertSame($commitInformation["files"]["filename"], "another_folder/FileSix.php");
    }

    /**
     * @test
     * @throws \Exception
     */
    public function commitInformationThrowsExceptionOnEmptySHA()
    {
        $this->expectException("Exception");

        $githubClient = new GithubClient($this->clientMock->reveal(), $this->resultPagerMock->reveal());

        $githubClient->getCommitInformation("user", "repo", "");
    }
}