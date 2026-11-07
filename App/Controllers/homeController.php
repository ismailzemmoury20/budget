<?php
namespace App\Controllers;
use App\App;
use App\Middleware\AuthMiddleware;

class homeController {
    public function index(){
        AuthMiddleware::check();
        $app = App::getInstance();
        $transactionTable = $app->getTable('transaction');

        if (isset($_GET['export']) && $_GET['export'] === 'csv') {
            $csv = $transactionTable->toCsvFile($transactionTable->findAllWithCategory());
            $filename = 'transactions_' . date('Y-m-d') . '.csv';
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            echo $csv;
            exit;
        }

        // Modifier / supprimer une transaction depuis le tableau de bord
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $id = (int) ($_POST['id'] ?? 0);
            if ($action === 'edit' && $id > 0) {
                $transactionTable->update($id, [
                    'montant' => (float) $_POST['montant'],
                    'description' => trim($_POST['description'] ?? ''),
                    'type' => $_POST['type'] === 'revenu' ? 'revenu' : 'depense',
                    'date' => $_POST['date'],
                ]);
            }
            if ($action === 'delete' && $id > 0) {
                $transactionTable->delete($id);
            }
            header('Location: index.php?p=home' . (isset($_GET['m']) ? '&m=' . urlencode($_GET['m']) : ''));
            exit;
        }

        // Mois affiché : ?m=2026-10, sinon le mois en cours
        $year = (int) date('Y'); $month = (int) date('n');
        if (isset($_GET['m']) && preg_match('/^(\d{4})-(\d{2})$/', $_GET['m'], $mm)) {
            $year = (int) $mm[1]; $month = max(1, min(12, (int) $mm[2]));
        }
        $summary = $transactionTable->monthSummary($year, $month);
        $isCurrentMonth = ($year === (int) date('Y') && $month === (int) date('n'));

        $totalRevenu  = (float) ($transactionTable->getTotalRevenu()->total ?? 0);
        $totalDepense = (float) ($transactionTable->getTotalDepense()->total ?? 0);
        $sold = round($totalRevenu - $totalDepense, 2);
        $transactionCount = count($transactionTable->findAll());

        $prev = date('Y-m', mktime(0, 0, 0, $month - 1, 1, $year));
        $next = date('Y-m', mktime(0, 0, 0, $month + 1, 1, $year));
        $pageTitle = 'Tableau de bord';
        $activeNav = 'home';

        require __DIR__ . '/../../view/pages/home.php';
    }
}
