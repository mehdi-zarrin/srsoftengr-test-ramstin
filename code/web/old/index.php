<?php
require_once 'functions.php';

$conn = connection();
$token = get_auth_token();
save($token);
echo '{"status": "ok"}'."\n";
