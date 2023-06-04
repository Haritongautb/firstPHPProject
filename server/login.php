<?php

use src\HistoryLog;
use src\User;

require_once __DIR__ . '/include.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/clients/global.css"/>
</head>
<body>

<form method="POST" action="/server/login.php">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="date" placeholder="password" required>
    </div>
    <button type="submit" class="btn btn-primary">Log in</button>
</form>

<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    die();
}

$user = new User();

$result = $user->getUser($email);
if ($user->isAdmin($email, $password) === true) {
    header("Location: /server/admin.php");
    exit();
}

if ($result) {
    $row = $result;
    if ($password === $row['password']) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['login'];
        echo "Authorization successful!!";
        $user_id = $_SESSION['user_id'];
        $hl = new HistoryLog();
        $hl->updateHistoryLog($user_id);
        header("Location: /server/setUserValues.php");
        exit();
    } else {
        echo "Wrong password";
    }
} else {
    echo "No user found with this email address";
    header("Location: /server/signup.php");
    exit();
}
?>
</body>
</html>
