<?php

use src\User;

require_once __DIR__ . '/include.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../clients/global.css"/>
</head>
<body>


<form method="POST" action="/server/signup.php">
    <div class="mb-3">
        <label for="username" class="form-label">User name</label>
        <input type="text" class="form-control" name="username" id="username" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">email: </label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">password: </label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <button type="submit" class="btn btn-primary" value="Signup">Sign up</button>
</form>

<?php
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
if (empty($username) || empty($email) || empty($password)) {
    die();
}
$user = new User();
$user->register($email, $username, $password);
?>
</body>
</html>
