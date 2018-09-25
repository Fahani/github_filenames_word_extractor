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
}