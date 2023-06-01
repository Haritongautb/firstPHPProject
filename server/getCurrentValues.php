<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $c="test";

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

    for($i = 0; $i < count($a); $i++){
        $b[] = mysqli_fetch_assoc(mysqli_query($conn,"SELECT date, name, var FROM curent WHERE name like ('$a[$i]') ORDER BY DATE DESC LIMIT 1"));
    }


    echo json_encode($b);

?>