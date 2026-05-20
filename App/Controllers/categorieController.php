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

            if($action === 'add'){
                $categorieTable->insert([
                    'nom'  => $_POST['nom'],
                    'type' => $_POST['type']
                ]);
            }  
            if ($action === 'edit') {
                $categorieTable->update((int)$_POST['id'], [
                    'nom'  => $_POST['nom'],
                    'type' => $_POST['type']
                ]);
            }

            if ($action === 'delete') {
                $categorieTable->delete((int)$_POST['id']);
            }
            header('Location: ?p=categorie');
            exit;
        }

        $categoriesMontant = $categorieTable->getTotalByCategorie();
        $pageTitle = 'Catégories';
        $pageIcon  = 'ri-pie-chart-line';
        require __DIR__ . '/../../view/pages/categorie.php';
    }
}
