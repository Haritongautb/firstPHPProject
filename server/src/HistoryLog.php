<?php

namespace src;

class HistoryLog
{
    private DataBase $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public function updateHistoryLog($user_id): void
    {
        $this->dataBase->exec("DELETE FROM history_log");
        $this->dataBase->exec("INSERT INTO history_log(id) values ('$user_id')");
    }

    public function getLastRecord(): int
    {
        $history_log = $this->dataBase->fetch('SELECT max(id) FROM history_log ORDER BY max(id) DESC LIMIT 1');
        return (int)$history_log['max(id)'];
    }
}
