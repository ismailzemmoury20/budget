<?php
namespace App;
use App\Database;


class App{
    public $title = "Budget";
    private static $db_instance;
    private static $_instance;

    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new App();
        }
        return self::$_instance;
    }
    public function getTable($name){
        $class_name = '\\App\\Table\\' . ucfirst($name) . 'Table';
        return new $class_name();
    }
    public function getDb(){
        $config = Config::getInstance();
        if(self::$db_instance === null){
            self::$db_instance = new Database($config->get('db_name'), $config->get('db_host'), $config->get('db_user'), $config->get('db_pass'));
        }
        return self::$db_instance;
    }

}
