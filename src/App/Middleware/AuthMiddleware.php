<?php
namespace App\Middleware;


class AuthMiddleware{
    public static function check(): void{
        if(!isset($_SESSION['user'])){
            header('Location: index.php?p=login');
            exit;
        }
    }
}



?>