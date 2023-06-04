<?php

use src\Admin;

require_once __DIR__ . '/include.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/clients/admin.css"/>
</head>
<body>
<div class="container">
    <h1>Admin Page</h1>

    <div class="forms">
        <div class="form-block currency-form-block">
            <form method="POST" action="/server/admin.php">
                <div class="mb-3">
                    <label for="currency" class="form-label">Alphabetic currency code</label>
                    <input type="text" class="form-control" name="current" id="currency">
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Set date</label>
                    <input type="date" class="form-control" name="date" id="date">
                </div>
                <div class="mb-3">
                    <label for="value" class="form-label">Set price</label>
                    <input type="number" class="form-control" name="value" id="value">
                </div>
                <button type="submit" class="btn btn-primary">Set new value</button>
            </form>
        </div>
    </div>

    <div class="content">
        <div class="content-header">
            <h2>user's wallet - </h2>
            <button type="button" class="btn btn-primary" id="get-data">Get user's data</button>
        </div>

        <div class="content-body">

        </div>
    </div>

    <?php
    $current = $_POST['current'] ?? '';
    $date = $_POST['date'] ?? '';
    $value = $_POST['value'] ?? '';
    if (!empty($current) || !empty($date) || !empty($value)) {
        $admin = new Admin();
        $admin->insertCur($current, $date, $value);
    }
    ?>
</div>
<script src="/clients/admin.js"></script>
</body>
</html>
