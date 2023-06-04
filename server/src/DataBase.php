<?php

namespace src;

use PDO;
use PDOException;

class DataBase
{
    public static ?PDO $DB = null;

    public function __construct()
    {
        if (null === self::$DB) {
            try {
                $dbh = new PDO('mysql:host=localhost:3306;dbname=test1', 'root', 'test');
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }

            self::$DB = $dbh;
        }
    }

    public function __destruct()
    {
        self::$DB = null;
    }

    public function fetch(string $sql)
    {
        $result = self::$DB->query($sql, PDO::FETCH_ASSOC);
        return $result->fetch();
    }

    public function fetchAll(string $sql): bool|array
    {
        $result = self::$DB->query($sql, PDO::FETCH_ASSOC);
        return $result->fetchAll();
    }

    public function exec(string $sql): bool|int
    {
        return self::$DB->exec($sql);
    }
}
