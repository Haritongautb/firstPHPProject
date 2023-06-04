<?php

namespace src;

class User
{
    private DataBase $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public function register(string $email, string $username, string $password): void
    {
        $sql = "SELECT * FROM users  WHERE email = '$email'";
        $result = $this->dataBase->fetch($sql);
        if ($result) {
            echo "The user already exists";
        } else {
            $sql = "INSERT INTO users (login, email, password, currency, currency_q) VALUES ('$username', '$email', '$password', '', 0)";

            if ($this->dataBase->exec($sql)) {
                echo "Registration is successful!";
                header("Location: /server/login.php");
                exit();
            } else {
                echo "Registration error.";
            }
        }
    }

    public function getUser(string $email)
    {
        return $this->dataBase->fetch("SELECT * FROM users  WHERE email = '$email'");
    }

    public function findUserBy($id): array
    {
        return [$this->dataBase->fetch("SELECT * FROM users WHERE id='$id'")];
    }

    public function findUserByHistoryId($id)
    {
        return $this->dataBase->fetch("SELECT login, email FROM users WHERE id='$id'");
    }

    public function isAdmin(string $email, string $password): bool
    {
        $admin = $this->dataBase->fetch("SELECT login, password FROM admin");
        if ($admin['login'] == $email && $admin['password'] == $password) {
            return true;
        }
        return false;
    }

    public function updateUserCurrency($currency, $currency_q, $history_log): void
    {
        $this->dataBase->exec("UPDATE users SET currency='$currency', currency_q='$currency_q' WHERE id='$history_log'");
    }
}
