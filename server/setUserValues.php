<?php

use src\Current;
use src\HistoryLog;
use src\User;

require_once __DIR__ . '/include.php';

$user = new User();
$hl = new HistoryLog();
$current = new Current();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="/clients/getUsersData.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">

    <div class="user-profile">
        <h1>User Page</h1>
        <div class="user-profile-content">
            <?php
            $history_log = $hl->getLastRecord();
            $name = $user->findUserByHistoryId($history_log);
            echo '<div class="profile-content profile-name" style="font-size: 20px; font-weight: 700;">User name - ' . $name['login'] . '</div>';
            echo '<div class="profile-content profile-email" style="font-size: 20px; font-weight: 700;">User name - ' . $name['email'] . '</div>';
            ?>
        </div>
    </div>

    <div class="content">
        <div class="form-block">
            <form method="POST" action="/server/setUserValues.php">
                <div class="mb-3">
                    <label for="currency" class="form-label">Alphabetic currency code</label>
                    <input type="text" class="form-control" name="currency" id="currency">
                </div>
                <div class="mb-3">
                    <label for="currency_q" class="form-label">Set value</label>
                    <input type="number" class="form-control" name="currency_q" id="currency_q">
                </div>
                <button type="submit" class="btn btn-primary">Update my wallet</button>
            </form>
        </div>

        <div class="grafik-block">
            <form method="POST" action="/server/setUserValues.php">
                <?php
                $a = $current->getCurrent();
                for ($i = 0; $i < count($a); $i++) {
                    echo '<button type="submit" name=' . $a[$i] . '>' . $a[$i] . '</button>';
                }
                ?>
            </form>
            <?php
            $c = '';
            $d = [];
            $v = [];
            foreach ($a as $var) {
                if (isset($_POST["$var"])) {
                    [$d, $v] = $current->getCurrentData($var);
                }
            }

            $currency = $_POST['currency'] ?? null;
            $currency_q = $_POST['currency_q'] ?? null;
            if (null !== $currency && null !== $currency_q) {
                $user->updateUserCurrency($currency, $currency_q, $history_log);
            }
            ?>
            <div class="grafik-block">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="exchange-block">
            <select class="form-select mb-4" aria-label="Default select example" id="select-currency">
                <option value="USD">USD</option>
                <option value="EURO">EURO</option>
                <option value="FRANK">FRANK</option>
            </select>

            <div class="current-exchange">
                <span class="currency">1 USD = </span>
                <span class="pln">100</span>
            </div>

            <input type="number" id="exchanged">
            <div class="result">0</div>
        </div>

    </div>

</div>

<input type="hidden" value="<?php echo urlencode(json_encode($d)); ?>" id="label-data">
<input type="hidden" value="<?php echo urlencode(json_encode($v)); ?>" id="data-2">
<script src="/clients/script.js"></script>
</body>
</html>
