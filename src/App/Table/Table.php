<?php
namespace App\Table;
use App\App;

class Table{

    protected $table;

    protected function getPDO(){
        return App::getInstance()->getDb()->getPDO();
    }
    public function __construct()
    {
        $parts = explode('\\', get_class($this));
        $class_name = end($parts);
        $this->table = strtolower(str_replace('Table', '', $class_name));
    }

    public function find($id){
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }
    public function findAll(){
        return $this->query("SELECT * FROM {$this->table}");
    }
    protected  function query($sql, $params = [], $one = false){
        if(empty($params)){
            $req =  $this->getPDO()->query($sql);
        } else {
             $req = $this->getPDO()->prepare($sql);
             $req->execute($params);
        }
        $req->setFetchMode(\PDO::FETCH_OBJ);
        if($one){
            return $req->fetch();
        } else {
            return $req->fetchAll();
        }


    }
}
