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
        $server_name = "127.0.0.1";
        $user_name = "root";
        $password = "";
        $db_name = "test1";
    
        $connection = new mysqli($server_name, $user_name, $password, $db_name);
        if($connection->connect_error){
            echo("Database connection error: ". $connection->connect_error);
            die();
        }
    
        $username = $_POST['username']; 
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if(empty($username) || empty($email) || empty($password)){
            die();
        }
        $sql = "SELECT * FROM users  WHERE email = '$email'";
        $result = $connection->query($sql); 
        if($result->num_rows > 0){
            echo "The user already exists";
        } else {
    
            $sql = "INSERT INTO users (login, email, password) VALUES ('$username', '$email', '$password')";
    
            if($connection->query($sql) === TRUE){
                echo "Registration is successful!";
                $connection->close();
                header("Location: http://logtest/server/login.php");
                exit();
            } else {
                echo "Registration error: ". $connection->error;
            }
        }
    
        $connection->close();

    ?>
    
</body>
</html>










