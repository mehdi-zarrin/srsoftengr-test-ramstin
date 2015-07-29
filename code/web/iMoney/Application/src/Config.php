<?php


namespace Application\src;

class Config
{
    public static $minQueueSize = 10;

    public static $dbDetails = [
            'db_name' => 'imoney',
            'db_user' => 'root',
            'db_pass' => '',
            'db_host' => 'localhost',
        ];

    public static $validKeys = [
            'name',
            'mobno',
            'email'
        ];
}
