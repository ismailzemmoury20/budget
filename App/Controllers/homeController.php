<?php
namespace App\Controllers;
use App\App;
use App\Middleware\AuthMiddleware;

class homeController {
    public function index(){
        AuthMiddleware::check();
        $app = App::getInstance();
        $transactionTable = $app->getTable('transaction');
        $transactions = $transactionTable->findAll();
        $totalRevenu = $transactionTable->getTotalRevenu('revenu')->total ?? 0;
        $totalDepense = $transactionTable->getTotalDepense('depense')->total ?? 0;
        $sold = $transactionTable->getSold();
        $transactions = $transactionTable->getlastTransaction();
        if(isset($_GET['export']) && $_GET['export'] === 'csv'){
            $transactions = $transactionTable->findAllWithCategory();
            $csv = $transactionTable->toCsvFile($transactions);

            $filename = 'transactions_' . date('Y-m-d') . '.csv';
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            echo $csv;
            exit;
        }
        $label         = ['revenus', 'dépenses'];
        $data          = [$totalRevenu, $totalDepense];
        $pageTitle     = 'Tableau de bord';
        $pageIcon      = 'ri-dashboard-line';

        require __DIR__ . '/../../view/pages/home.php';

    }

}

?>