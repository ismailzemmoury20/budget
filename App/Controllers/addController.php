<?php
namespace App\Controllers;
use App\App;
use App\Middleware\AuthMiddleware;

class addController
{
    public function index(): void
    {
        AuthMiddleware::check();
        $app = App::getInstance();
        $transactionTable = $app->getTable('transaction');
        $categorieTable = $app->getTable('categorie');
        $categorie = $categorieTable->findAll();
        $pageTitle = 'Nouvelle transaction';
        $activeNav = 'add';
        $success = null;
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $montant = (float) str_replace(',', '.', $_POST['montant'] ?? '0');
            $date = $_POST['date'] ?? '';
            if ($montant <= 0) {
                $error = 'Indiquez un montant supérieur à 0 €.';
            } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                $error = 'Indiquez la date de l\'opération.';
            } else {
                $result = $transactionTable->insert([
                    'montant' => $montant,
                    'description' => trim($_POST['description'] ?? ''),
                    'type' => ($_POST['type'] ?? '') === 'revenu' ? 'revenu' : 'depense',
                    'categorie_id' => ($_POST['categorie_id'] ?? '') !== '' ? (int) $_POST['categorie_id'] : null,
                    'date' => $date,
                    'notes' => trim($_POST['notes'] ?? '') ?: null,
                ]);
                if ($result) {
                    $_SESSION['flash_success'] = 'Opération enregistrée : ' . (trim($_POST['description'] ?? '') ?: 'sans description') . '.';
                    header('Location: index.php?p=add');
                    exit;
                }
                $error = "L'opération n'a pas pu être enregistrée. Réessayez.";
            }
        }

        if (isset($_SESSION['flash_success'])) {
            $success = $_SESSION['flash_success'];
            unset($_SESSION['flash_success']);
        }

        // Pour l'aperçu : où en est le mois en cours
        $summary = $transactionTable->monthSummary((int) date('Y'), (int) date('n'));
        require __DIR__ . '/../../view/pages/add.php';
    }
}
