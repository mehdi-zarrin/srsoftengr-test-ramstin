<?php

    require 'vendor/autoload.php';

    Resque::setBackend('127.0.0.1:6379');
    $jobId = Resque::enqueue('default', '\Application\src\LeadCollector', $_REQUEST, true);

    echo "Queued job in 'default' Queue with jobId : {$jobId} ".PHP_EOL;
