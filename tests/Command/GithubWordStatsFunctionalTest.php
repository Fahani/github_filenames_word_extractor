<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 20:53
 */

namespace App\Tests\Command;

use App\Command\GithubWordsStats;
use App\Service\GithubClient;
use App\Service\WordCounter;
use Github\Client;
use Github\ResultPager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GithubWordStatsFunctionalTest extends KernelTestCase
{
    private $githubCommand;

    protected function setUp()
    {
        $client = new Client();
        $resultPager = new ResultPager($client);
        $githubClient = new GithubClient($client, $resultPager);
        $wordCounter = new WordCounter();
        $this->githubCommand = new GithubWordsStats($githubClient, $wordCounter);
    }

    /**
     * @test
     */
    public function testExecuteAndReturnsExpectedData()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $application->add($this->githubCommand);

        $command = $application->find('github:words-stats');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'username' => 'fahani',
            'repository' => 'colvin',
            '--extension' => 'php',
        ));

        $output = $commandTester->getDisplay();

        $this->assertContains('Six', $output);
        $this->assertContains('Words', $output);
        $this->assertContains('Frequencies', $output);
        $this->assertContains('4', $output);
        $this->assertContains('File', $output);
    }
}