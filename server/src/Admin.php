<?php

namespace src;

class Admin
{
    private DataBase $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public function insertCur($current, $date, $value): void
    {
        $this->dataBase->exec("INSERT INTO curent(name, date, var) value('$current', '$date', '$value')");
    }
}
