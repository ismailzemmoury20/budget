<?php
namespace App\Controllers;
use App\App;
use App\Middleware\AuthMiddleware;

class homeController {
    public function index(){
        AuthMiddleware::check();
        $app = App::getInstance();
        $transactionTable = $app->getTable('transaction');
        $user_id = $_SESSION['user']->id;
        $totalRevenu = $transactionTable->getTotalRevenu($user_id)->total ?? 0;
        $totalDepense = $transactionTable->getTotalDepense($user_id)->total ?? 0;
        $sold = $transactionTable->getSold($user_id);
        $transactions = $transactionTable->getLastTransaction($user_id);
        if(isset($_GET['export']) && $_GET['export'] === 'csv'){
            $transactions = $transactionTable->findAllWithCategory($user_id);
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

        require __DIR__ . '/../../../view/pages/home.php';

    }

}

?>