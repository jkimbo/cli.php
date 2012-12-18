# CLI php helper

A small collection of php classes to help with CLI utilities. 

## Installation 

Add this to your `composer.json`
    
    "repositories": [
        {
            "type": "git",
            "url": "git@code.fusepump.com:cli.php"
        }
    ],
    "require": {
        "fusepump/cli.php": "dev-master"
    }

Then run:

    composer install

And add `require 'vendor/autoload.php'` to your php file;

- - -

## Inputs.php

### Parse inputs

Parse command line inputs

__Example:__

	<?php
	require 'lib/Inputs.php';
	$cli = new Inputs($argv);
	
	$cli->option('-h, --ham', 'Add ham');
	$cli->option('-m, --mayo', 'Add mayonaise');
	$cli->option('-c, --cheese [type]', 'Add a cheese');
	$cli->option('-b, --bread [type]', 'Type of bread', true); // required input
	
	if(!$cli->parse()) {
		exit(1);	
	}
	
	echo "You ordered a sandwich with: \n";
	if($cli->get('-h')) echo " - Ham \n";
	if($cli->get('-m')) echo " - Mayonaise \n";
	if($cli->get('--cheese')) echo ' - '.$cli->get('--cheese')." cheese \n";
	echo 'On '.$cli->get('-b')." bread \n";

__Run:__

	php cli.php -h -c cheddar --bread white

__Gives:__
	
	You ordered a sandwich with:
	 - Ham
	 - Cheddar cheese
	On white bread

### Prompts

Prompt the user for information.

__Example:__
	
	<?php
	require('lib/Inputs.php');
	$cli = new Inputs();

	$username = $cli->prompt('Username: ');
	echo 'Got '.$username."\n";

	$password = $cli->prompt('Password (not a real one): ', true);
	echo 'Got '.$password."\n";

	$confirm = $cli->confirm('Confirm? ');
	echo var_dump($confirm);

__N.B.__ Confirm returns true on a "y" or "yes". It returns false otherwise. 

- - -

## Logger

Logger class with colour and timestamps.

__Example:__
    
    Logger::log('Hello!'); // => [2012-11-15 18:12:34] [log] [logging.php] Hello!
    Logger::log('This is red!', array('colour' => 'red')); // => [2012-11-15 18:12:34] [log] [logging.php] This is red!
    Logger::log('This is green!', array('colour' => 'green')); // => [2012-11-15 18:12:34] [log] [logging.php] This is green!

    Logger::log('Custom formatting options!', array('format' => '[%s] %s', 'inputs' => array('custom_log'))); // => [Custom log] Custom formatting options!

    Logger::error('This is an error'); // => [2012-11-15 18:12:34] [error] [logging.php] This is an error

    Logger::out('Plain output'); // => Plain output
    Logger::out('Plain output with colour!', 'red'); // => Plain output with colour!

- - -

## Utils

Collection of utility functions.

### exec

Execute a shell command. Throws an exception if command fails.

__Example:__

    <?php
    require 'lib/Utils.php';

    Utils::exec('echo hello!'); // => hello!
    
    $value = Utils::exec('echo hello!', true);
    echo $value; // => hello!

### jsonDecode

Decode JSON string into an associative array. Throw exception with information if fails to parse JSON string.

__Example:__
    
    <?php
    require 'lib/Utils.php';

    $json = Utils::jsonDecode('{"hello": "world"}');
    
    echo $json['hello']; // => world
    
### checkEnv

Check that an environmental variable is set. Can take a single variable or an
array of variables to set. Throws an Exception if the variable is not set. 

__Example:__
    <?php
    require 'lib/Utils.php';
    
    Utils::checkEnv(array(
        'FOO',
        'BAR'
    ));
    
    Utils::checkEnv('FOO');

### pregMatchArray

Match subject to an array of regex patterns. Returns true if found a match.
False if not.

__Example:__
    <?php
    require 'lib/Utils.php';
    
    Utils::pregMatchArray(array(
        '/foo/i',
        '/bar/i'
    ), 'foo'); // => true
    
