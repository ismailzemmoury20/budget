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
    $activeNav = 'deconnexion';
    $transactionTable = \App\App::getInstance()->getTable('transaction');
    $totalRevenu  = (float) ($transactionTable->getTotalRevenu()->total ?? 0);
    $totalDepense = (float) ($transactionTable->getTotalDepense()->total ?? 0);
    $sold = round($totalRevenu - $totalDepense, 2);
    $transactionCount = count($transactionTable->findAll());
    $summary = $transactionTable->monthSummary((int) date('Y'), (int) date('n'));
    require __DIR__ . '/../../view/pages/deconnexion.php';
    }
}
