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
        $pageTitle = 'Ajouter une transaction';
        $pageIcon  = 'ri-add-circle-line';
        $success = null;
        $error = null;

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $data = [
                'montant' => $_POST['montant'],
                'description' => $_POST['description'],
                'type' => $_POST['type'],
                'categorie_id' => $_POST['categorie_id'],
                'date' => $_POST['date'],
                'notes' => $_POST['notes']
            ];
            $result = $transactionTable->insert($data);
            if($result){
                $_SESSION['flash_success'] = "La transaction a été enregistrée avec succès !";
                header('Location: ?p=add');
                exit;
            } else {
                $error = "Une erreur est survenue lors de l'enregistrement.";
            }
        }

            if(isset($_SESSION['flash_success'])){
            $success = $_SESSION['flash_success'];
            unset($_SESSION['flash_success']);
            }
            require __DIR__ . '/../../view/pages/add.php';
    }
}
