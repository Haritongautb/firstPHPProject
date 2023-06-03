<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../clients/admin.css"/>
</head>
<body>

    <div class="container">
        <h1>Admin Page</h1>

        <div class="forms">
            <div class="form-block currency-form-block">
                <form method="POST" action="http://logtest/server/admin.php">
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

            $server_name = "127.0.0.1";
            $user_name = "root";
            $password = "";
            $db_name = "test1";

            try{
                $connection = new mysqli($server_name, $user_name, $password, $db_name);
                if($connection->connect_error){
                    echo("Database connection error: ". $connection->connect_error);
                }
            } catch(Exception $e){
                var_dump($e);
            }

            $current = $_POST['current'];
            $date = $_POST['date'];
            $value = $_POST['value'];

            if(!empty($current) || !empty($date) || !empty($value)){
                mysqli_query($connection, "INSERT INTO curent(name, date, var) value('$current', '$date', '$value')");
                echo json_encode($date);
                echo json_encode($value);
            }
        ?>
    </div>


    <script>
        const btn = document.getElementById("get-data");
        const contentBody = document.querySelector(".content-body");
        const methods = {
            "get": "GET"
        }

        btn.addEventListener("click", getUsersData.bind(this))

        function getUsersData(event) {
            event.preventDefault();

            if(event && event.target){
                request("http://logtest/server/getUsersData.php", methods.get)
                .then(res => {
                    console.log(res);
                    res.map((item => {
                        contentBody.innerHTML += buildUsersCard(item);
                    }))
                })
            }
        }

        async function request(url, method) {
            const res = await fetch(url, {
                method
            })

            return await res.json();
        }

        function buildUsersCard(data) {
            const {login, email, id, currency, currency_q} = data;
            return `
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">${id}</h5>
                    <h5 class="card-title">${login}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">currency - ${currency ? currency : "none"} ${currency_q ? currency_q : "none"}</h6>
                </div>
            </div>
            `
        }

    </script>
</body>
</html>



