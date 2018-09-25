# Github Filenames Word Extractor

Hi there! This repository holds the code to run a PHP application made with Symfony 4 along with unit, integration and 
functional tests.
The purpose of this application is to shows you the words used in the filenames of a Github repository, and its frequency.

## Usage

To use this application, open a terminal and navigate to the root directory of the project, then type the next command:

```
Windows: php bin/console github:words-stats username repository --extension=php
```

```
Linux: ./bin/console github:words-stats username repository --extension=php
```

The first parameter is the username who owns the repository in Github.  
The second parameter is the repository from which you want to extract the words.  
The option --extension is optional. Use it if you only want to process files that have that extension.  
  
## Setup
1. Clone the repository. Open a terminal and navigate to the directory where you want to have this application. Then type:

    ```
    git clone https://github.com/Fahani/github_filenames_word_extractor.git
    ```
    
2. Make sure you have [Composer installed](https://getcomposer.org/download/) installed. 
Then navigate inside the new directory and install the libraries and dependencies and run:
    
    ```
    composer install
    ```
    
    The application is a symfony/skeleton project and the two main libraries used are:
    
    - [PHPUnit for testing](https://phpunit.de/). 
    - [Github Apli Client](https://github.com/KnpLabs/php-github-api).

3. Because we are going to use the Github API, they only allow 60 queries per hour when you are not authenticated. To get 
rid of this restriction, I recommend you to [get a personal token in your github account](https://help.github.com/articles/creating-a-personal-access-token-for-the-command-line/).  
Once you have the token, put it into your .env file:

    ```
    ###> knplabs/github-api ###
    GITHUB_AUTH_METHOD=http_token
    GITHUB_USERNAME=your username
    GITHUB_SECRET=your token
    ###< knplabs/github-api ###
    ```
    
    And also put it into your phpunit.xml.dist file:
    
    ```
    <!-- ###+ knplabs/github-api ### -->
    <env name="GITHUB_AUTH_METHOD" value="http_token"/>
    <env name="GITHUB_USERNAME" value="your username"/>
    <env name="GITHUB_SECRET" value="your token"/>
    <!-- ###- knplabs/github-api ### -->
    ```
    
## Tests

To run the tests you just have to go to a terminal, navigate to the root of the project's directory and run:

```
Windows:
php bin/phpunit
```

```
Linux:
./bin/phpunit
```

## Continuous Integration

I did continuous integrating with [CircleCI](https://circleci.com/). The configuration is provided inside the .circleci directory.

## Have Ideas, Feedback or an Issue?

If you have suggestions or questions, please feel free to open an issue on this repository.