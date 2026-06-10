<?php
namespace App\Controllers;
use App\App;

class loginController
{
    public function index(): void
    {
        $app = App::getInstance();
        $userTable = $app->getTable('user');
        if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username']) && !empty($_POST['password'])){
            $user = $userTable->getByUsername($_POST['username']);

        if($user && password_verify($_POST['password'], $user->password)){
            $_SESSION['user'] = $user;
            header('Location: index.php?p=home');
            exit();
        } else {
            $error = 'Identifiants incorrects';
        }
        }
        require __DIR__ . '/../../../view/pages/login.php';
    }
}
