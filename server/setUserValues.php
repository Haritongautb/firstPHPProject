<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link href="../clients/getUsersData.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="container">

        <div class="user-profile">
            <h1>User Page</h1>
            <div class="user-profile-content">
                <?php   
                    $servername = "127.0.0.1";
                    $username = "root";
                    $password = "";
                    $c="test1";
    
                    $conn =  new mysqli($servername, $username, $password,$c);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $history_log = mysqli_fetch_assoc(mysqli_query($conn, "SELECT max(id) FROM history_log ORDER BY max(id) DESC LIMIT 1"));
                    $history_log = $history_log['max(id)'];
                    $name = mysqli_fetch_assoc(mysqli_query($conn, "SELECT login, email FROM users WHERE id='$history_log'"));
                    echo '<div class="profile-content profile-name" style="font-size: 20px; font-weight: 700;">User name - '.$name['login'].'</div>';
                    echo '<div class="profile-content profile-email" style="font-size: 20px; font-weight: 700;">User name - '.$name['email'].'</div>';
                ?>
            </div>
        </div>

        <div class="content">
            <div class="form-block">
                <form method="POST" action="http://logtest/server/setUserValues.php">
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

            <?php
                $servername = "127.0.0.1";
                $username = "root";
                $password = "";
                $c="test1";

                $conn =  new mysqli($servername, $username, $password,$c);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
            
                $id= mysqli_fetch_assoc(mysqli_query($conn,"select max(id) from curent"));
                $id=$id['max(id)'];
                for ($i=1;$i!=$id+1;$i++){
                    if(mysqli_fetch_assoc(mysqli_query($conn,"SELECT DISTINCT name FROM curent where id=$i"))!=null){
                        $a[]=mysqli_fetch_assoc(mysqli_query($conn,"SELECT DISTINCT name FROM curent where id=$i"));
                    }
                }
                foreach ($a as $key => $value) {
                    $a1[]=$value['name'];
                }
                $a1= array_unique($a1);
                foreach ($a1 as $key => $value) {
                    $a2[]=$value;
                }
                $a=$a2;
            ?>

            <div class="grafik-block">
            <form method="POST" action="http://logtest/server/setUserValues.php">
                <?php
                    for($i=0;$i<count($a);$i++){
                        echo'<button type="submit" name='.$a[$i].'>'.$a[$i].'</button>';
                    }
                ?>
            </form>
                <?php
                    $c='';
                    foreach($a as $var){
                        if(isset($_POST["$var"])){
                            $c=$var;    
                            $idmin= mysqli_fetch_assoc(mysqli_query($conn,"select min(id) from curent where name like('$c')"));
                            $id= mysqli_fetch_assoc(mysqli_query($conn,"select max(id) from curent where name like('$c')"));
                            $id=$id['max(id)'];
                            $idmin=$idmin['min(id)'];
                            for ($i=$idmin;$i!=$id+1;$i++){
                                if(mysqli_fetch_assoc(mysqli_query($conn,"SELECT DISTINCT date FROM curent where name like('$c')and id=$i"))!=null){
                                    $d[]=mysqli_fetch_assoc(mysqli_query($conn,"SELECT DISTINCT date FROM curent where name like('$c') and id=$i "));
                                }
                            }
                            foreach ($d as $key => $value) {
                                
                                $d1[]=$value['date'];
                            }
                            $d1= array_unique($d1);
                            foreach ($d1 as $key => $value) {
                                $d2[]=$value;
                            }
                            $d=$d2;
                            
                            for ($i=$idmin;$i!=$id+1;$i++){
                                if(mysqli_fetch_assoc(mysqli_query($conn,"SELECT DISTINCT var FROM curent where name like('$c')and id=$i"))!=null){
                                    $v[]=mysqli_fetch_assoc(mysqli_query($conn,"SELECT DISTINCT var FROM curent where name like('$c')and id=$i"));
                                }
                            }
                                foreach ($v as $key => $value) {
                                $v1[]=$value['var'];
                            }
                            $v1= array_unique($v1);
                            foreach ($v1 as $key => $value) {
                                $v2[]=$value;
                            }
                            $v=$v2;
                        }
                    }
                    $currency = $_POST['currency'];
                    $currency_q = $_POST['currency_q'];
            
                    mysqli_query($conn, "UPDATE users SET currency='$currency', currency_q='$currency_q' WHERE id='$history_log'");
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

    <input type="hidden" value="<?php var_dump($d); echo json_encode($d);?>" id="label-data">
    <input type="hidden" value="<?php echo json_encode($v);?>" id="data-2">
    <script src="../clients/script.js">
    </script>


</body>
</html>
