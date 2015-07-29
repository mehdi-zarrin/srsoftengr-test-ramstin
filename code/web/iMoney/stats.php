<?php


    $start = microtime(true);
    require 'vendor/autoload.php';
    use Application\src\Database;
    use Application\src\StatsHandler;

    $stats = new StatsHandler((new Database()));
    $response = [
        'last_15_min_lead_count' => $stats->leadCount(),
        'time_span_last_10k' => $stats->timeSpan(),
    ];

    echo PHP_EOL.json_encode($response).PHP_EOL;
    echo PHP_EOL.'Total Execution Time: '.(microtime(true) - $start).PHP_EOL;
