<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');

function connection() {
    global $DB;
    $DB = mysql_connect(DB_HOST, DB_USER, DB_PASS);
    mysql_select_db('imoney');
}

function get_auth_token() {
    $arg = json_encode($_REQUEST);
    return `./token $arg`;
}

function save($token) {
    global $DB;
    mysql_query(
        "insert into imoney values (
            NULL,
            '{$_REQUEST['name']}',
            '{$_REQUEST['mobno']}',
            '{$_REQUEST['email']}',
            '{$token}',
            now()
            );
        "
    );
}
