<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=utf-8');

    $server_name = "127.0.0.1";
    $user_name = "root";
    $password = "";
    $db_name = "test";

    try{
        $connection = new mysqli($server_name, $user_name, $password, $db_name);
        if($connection->connect_error){
            echo("Database connection error: ". $connection->connect_error);
        }
    } catch(Exception $e){
        var_dump($e);
    }

    $id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT max(id) FROM users"));
    $id = $id['max(id)'];

    for($i = 1; $i != ($id + 1); $i++){
        $c = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id='$i'"));
        if($c != null){
            $b[] = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM users WHERE id='$i'"));
        }
    }
    echo json_encode($b);

?>
