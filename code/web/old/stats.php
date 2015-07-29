<?php
require_once 'functions.php';

$response = array();
$conn = connection();
$t15m_ago = new DateTime("15 minutes ago");
$s = $t15m_ago->format("Y-m-d H:i:s");
$result = mysql_query("SELECT count(*) from imoney where created_at > '$s'");
$response['last_15_min_lead_count'] = current(mysql_fetch_row($result));
$result = mysql_query("SELECT min(created_at), max(created_at) from imoney order by id DESC limit 10000");
$response['time_span_last_10k'] = mysql_fetch_row($result);

echo json_encode($response)."\n";
