<?php
namespace App\Controllers;
use App\App;
use App\Middleware\AuthMiddleware;

class deconnexionController
{
    public function index(): void
    {
    AuthMiddleware::check();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_destroy();
        header('Location: index.php?p=landing');
        exit;
    }

    $pageTitle = 'Déconnexion';
    $pageIcon  = 'ri-logout-circle-r-line';

    ob_start();
        require __DIR__ . '/../../../view/pages/deconnexion.php';
    }
}
