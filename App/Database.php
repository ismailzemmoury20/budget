<?php
namespace App;
use PDO;

class Database{
    private $db_name;
    private $db_host;
    private $db_user;
    private $db_pass;
    private $pdo;

    function __construct($db_name, $db_host, $db_user, $db_pass )
    {
        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
    }
    public function getPDO(){
        if($this->pdo === null){
            $pdo = new PDO('mysql:dbname=' . $this->db_name . ';host=' . $this->db_host, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }
    public function query($stmt, $class_name, $one = false){
        $req = $this->getPDO()->query($stmt);
        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if($one){
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        return $datas;
    }
    public function prepare($stmt, $attributes, $class_name, $one = false){
        $req = $this->getPDO()->prepare($stmt);
        $req->execute($attributes);
        $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
        if($one){
            $datas = $req->fetch();
        } else {
            $datas = $req->fetchAll();
        }
        return $datas;
    }
}
