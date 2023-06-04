<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

use src\Current;

require_once __DIR__ . '/include.php';

$current = new Current();
echo json_encode($current->getCurrentValues());
