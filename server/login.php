<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../clients/global.css"/>
</head>
<body>

    <form method="POST" action="http://logtest/server/login.php">
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

    <!-- При успешной авторизации отправить на страницу user.html -->
    <!-- Там сделать на странице user.html стянуть информаицю о нем в отдельный блоок на странице-->
    <?php
        // что это значит? 
        // инициализация сессии, глобальный объект, который хранит в себе данные, и в последующих открытиях других php файлов можно найти данные из предыдущих скриптов
        // что-то типа localStorage
        session_start();

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

        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email) || empty($password)){
            die();
        }

        $sql = "SELECT * FROM users  WHERE email = '$email'";
        $result = $connection->query($sql); 

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($password === $row['password']) {

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['login'];
                echo "Authorization successful!!";
                $user_id = $_SESSION['user_id'];
                mysqli_query($connection, "DELETE FROM history_log");
                mysqli_query($connection, "INSERT INTO history_log(id) values ('$user_id')");
                $connection->close();
                header("Location: http://logtest/server/setUserValues.php");
                exit();
            } else {
                echo "Wrong password";
            }
        } else {
            echo "No user found with this email address";
            $connection->close();

            header("Location: http://logtest/server/signup.php");
            exit();
        }

        $connection->close();
    ?>
    
</body>
</html>






