<?php
namespace App\Controllers;
use App\App;
use App\Middleware\AuthMiddleware;

class categorieController
{
    public function index(): void
    {
        AuthMiddleware::check();
        $app = App::getInstance();
        $categorieTable = $app->getTable('categorie');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $action = $_POST['action'] ?? 'add';

            $nom = trim($_POST['nom'] ?? '');
            $type = ($_POST['type'] ?? '') === 'revenu' ? 'revenu' : 'depense';
            if (($action === 'add' || $action === 'edit') && $nom === '') {
                header('Location: ?p=categorie');
                exit;
            }
            if($action === 'add'){
                $categorieTable->insert([
                    'nom'  => $nom,
                    'type' => $type
                ]);
            }  
            if ($action === 'edit') {
                $categorieTable->update((int)$_POST['id'], [
                    'nom'  => $nom,
                    'type' => $type
                ]);
            }

            if ($action === 'delete') {
                $categorieTable->delete((int)$_POST['id']);
            }
            header('Location: ?p=categorie');
            exit;
        }

        $categoriesMontant = $categorieTable->getTotalByCategorie();
        $summary = $app->getTable('transaction')->monthSummary((int) date('Y'), (int) date('n'));
        $monthByCat = [];
        foreach ($summary['rows'] as $r) {
            if ($r->categorie_id === null) continue;
            $monthByCat[(int) $r->categorie_id] = ($monthByCat[(int) $r->categorie_id] ?? 0) + (float) $r->montant;
        }
        $monthLabel = \App\Format::monthName((int) date('n'));
        $pageTitle = 'Catégories';
        $activeNav = 'categorie';
        require __DIR__ . '/../../view/pages/categorie.php';
    }
}
