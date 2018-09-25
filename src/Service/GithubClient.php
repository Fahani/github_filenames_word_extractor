<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 19:50
 */

namespace App\Service;

use Github\Client;
use Github\ResultPager;

class GithubClient
{
    private $githubClient;

    private $resultPager;

    /**
     * GithubClient constructor.
     * @param Client $githubClient
     * @param ResultPager $resultPager
     */
    public function __construct(Client $githubClient, ResultPager $resultPager)
    {
        $this->githubClient = $githubClient;
        $this->githubClient->authenticate(getenv('GITHUB_SECRET'), null, getenv('GITHUB_AUTH_METHOD'));
        $this->resultPager = $resultPager;
    }

    /**
     * This function allows us to get all the commits from a repository.
     * @param string $user Username of the user in github
     * @param string $repository Repository from which we want to get the commits
     * @return array with all the commits in the repository
     */
    public function getAllCommitsInRepository(string $user, string $repository): array
    {
        $commitsApi = $this->githubClient->repo()->commits();
        $parameters = array($user, $repository, ['sha' => 'master']);
        $commits = $this->resultPager->fetchAll($commitsApi, 'all', $parameters);
        return $commits;
    }

    /**
     * This function returns the information of a commit, that info contains the information about the files in that commit
     * @param string $user Username of the user in Github
     * @param string $repository Repository from we want to get the filenames
     * @param string $sha SHA of the commit
     * @return array an array with the commit information
     * @throws \Exception
     */
    public function getCommitInformation(string $user, string $repository, string $sha): array
    {
        $commitInfo = $this->githubClient->api('repo')->commits()->show($user, $repository, $sha);

        return $commitInfo;
    }
}