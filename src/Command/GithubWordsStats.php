<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/09/2018
 * Time: 20:44
 */

namespace App\Command;


use App\Helper\FilenameWordSplitter;
use App\Helper\GithubInformationExtractor;
use App\Service\GithubClient;
use App\Service\WordCounter;
use Github\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GithubWordsStats extends Command
{
    protected static $defaultName = 'github:words-stats';

    private $githubClient;

    private $wordCounter;

    /**
     * Inject the needed dependencies to run the command
     * GithubWordsStats constructor.
     * @param GithubClient $githubClient Our service to get information from Github
     * @param WordCounter $wordCounter Our service to count the words and its frequency
     */
    public function __construct(GithubClient $githubClient, WordCounter $wordCounter)
    {
        $this->githubClient = $githubClient;
        $this->wordCounter = $wordCounter;
        parent::__construct();
    }


    /**
     * Configuring the command with the description, parameters and options
     */
    protected function configure()
    {
        $this
            ->setDescription('Returns the words used in the filename and its frequency ')
            ->addArgument('username', InputArgument::REQUIRED, 'Username to query')
            ->addArgument('repository', InputArgument::REQUIRED, 'Repository name to query')
            ->addOption('extension', null, InputOption::VALUE_OPTIONAL, 'Consider only the files with this extension', '')
        ;
    }

    /**
     * Executing the command, retrieving the info from the parameters and option.
     * Then use our services and helpers to extract the desired information from github
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getArgument('username');
        $repository = $input->getArgument('repository');
        $extension = $input->getOption('extension');

        try {
            $filesNames = $this->getPHPFilenameInRepository($username, $repository);
            $words = [];
            foreach ($filesNames as $filename) {
                $words = array_merge($words, FilenameWordSplitter::filenameToWords($filename, $extension));
            }
            foreach ($words as $word)
                $this->wordCounter->addWord($word);


            $rows = [];
            foreach ( $this->wordCounter->getWords() as $word) {
                $rows[] = [$word->getName(), $word->getFrequency()];
            }
            $io->table(["Words", "Frequencies"], $rows);

            $io->success('Success! Thank you for using my code.');

        } catch (RuntimeException $e) {
            $io->error( "Invalid username or repository, please check them." );
        } catch (\Exception $e) {
            $io->error( $e->getMessage() );
        }
    }

    /**
     * Get all the filenames from a user/repository in github.
     * @param string $user Username in github
     * @param string $repository The repository from which we want to extract the filenames
     * @return array An array with all the filenames
     * @throws \Exception
     */
    private function getPHPFilenameInRepository(string $user, string $repository): array
    {
        $allFilesName = [];

        $commits = $this->githubClient->getAllCommitsInRepository($user, $repository);

        foreach ($commits as $commit)
        {
            $commitInformation = $this->githubClient->getCommitInformation($user, $repository, $commit['sha']);
            $filesNameInCommit = GithubInformationExtractor::getFileNameInCommitInformation($commitInformation);
            $allFilesName = array_merge($allFilesName, $filesNameInCommit);
        }

        return $allFilesName;
    }
}