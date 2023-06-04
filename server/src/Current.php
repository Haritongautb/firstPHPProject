<?php

namespace src;

class Current
{
    private DataBase $dataBase;

    public function __construct()
    {
        $this->dataBase = new DataBase();
    }

    public function getCurrentValues(): array
    {
        $id = $this->dataBase->fetch("select max(id) from curent");
        $id = (int)$id['max(id)'];
        $a = [];
        for ($i = 1; $i != $id + 1; $i++) {
            $searchCurrent = $this->dataBase->fetch("SELECT DISTINCT name FROM curent where id=$i");
            if ($searchCurrent) {
                $a[] = $searchCurrent;
            }
        }
        $a1 = [];
        foreach ($a as $key => $value) {
            $a1[] = $value['name'];
        }
        $a1 = array_unique($a1);
        $a2 = [];
        foreach ($a1 as $key => $value) {
            $a2[] = $value;
        }
        $a = $a2;
        $b = [];
        for ($i = 0; $i < count($a); $i++) {
            $b[] = $this->dataBase->fetch("SELECT date, name, var FROM curent WHERE name like ('$a[$i]') ORDER BY DATE DESC LIMIT 1");
        }

        return $b;
    }

    public function getCurrent()
    {
        $id = $this->dataBase->fetch("select max(id) from curent");
        $id = (int)$id['max(id)'];
        $a = [];
        for ($i = 1; $i != $id + 1; $i++) {
            $searchCurrent = $this->dataBase->fetch("SELECT DISTINCT name FROM curent where id=$i");
            if ($searchCurrent) {
                $a[] = $searchCurrent;
            }
        }
        $a1 = [];
        foreach ($a as $key => $value) {
            $a1[] = $value['name'];
        }
        $a1 = array_unique($a1);
        $a2 = [];
        foreach ($a1 as $key => $value) {
            $a2[] = $value;
        }
        $a = $a2;
        return $a;
    }

    public function getCurrentData($var): array
    {
        $c = $var;
        $d = [];
        $v = [];
        $idmin = $this->dataBase->fetch("select min(id) from curent where name like('$c')");
        $id = $this->dataBase->fetch("select max(id) from curent where name like('$c')");
        $id = (int)$id['max(id)'];
        $idmin = (int)$idmin['min(id)'];
        for ($i = $idmin; $i != $id + 1; $i++) {
            $searchCurrent = $this->dataBase->fetch("SELECT DISTINCT date FROM curent where name like('$c')and id=$i");
            if ($searchCurrent) {
                $d[] = $searchCurrent;
            }
        }
        $d1 = [];
        foreach ($d as $key => $value) {
            $d1[] = $value['date'];
        }
        $d1 = array_unique($d1);
        $d2 = [];
        foreach ($d1 as $key => $value) {
            $d2[] = $value;
        }
        $d = $d2;
        for ($i = $idmin; $i != $id + 1; $i++) {
            $searchCurrent = $this->dataBase->fetch("SELECT DISTINCT var FROM curent where name like('$c')and id=$i");
            if ($searchCurrent) {
                $v[] = $searchCurrent;
            }
        }
        $v1 = [];
        foreach ($v as $key => $value) {
            $v1[] = $value['var'];
        }
        $v1 = array_unique($v1);
        $v2 = [];
        foreach ($v1 as $key => $value) {
            $v2[] = $value;
        }
        $v = $v2;

        return [$d, $v];
    }
}
