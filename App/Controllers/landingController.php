<?php
namespace App\Controllers;

class landingController
{
    public function index(): void
    {
        if (!empty($_SESSION['user'])) {
            header('Location: index.php?p=home');
            exit();
        }
        require __DIR__ . '/../../view/pages/landing.php';
    }
}
