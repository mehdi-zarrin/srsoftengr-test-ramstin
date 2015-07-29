#!/usr/bin/php
<?php
	
	// run : ./runWorker default || php runWorker default
	if (!array_key_exists('1', $argv) and empty($argv[1])) {
        echo 'please specify the queue name [ Example : default ]'.PHP_EOL;
        exit();
    }

    $queue = $argv[1];
    
	system("QUEUE={$queue} php vendor/chrisboulton/php-resque/resque.php");
