<?php

use src\User;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

session_start();

require_once __DIR__ . '/include.php';

$user = new User();
echo json_encode($user->findUserBy($_SESSION['user_id'] ?? 0));
