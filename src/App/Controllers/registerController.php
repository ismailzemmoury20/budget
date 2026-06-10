<?php
namespace App\Controllers;
use App\App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class registerController
{
    public function index(): void
    {
    $app = App::getInstance();
    $userTable = $app->getTable('user');
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordVerified = $_POST['password_confirm'] ?? '';

        if($_POST['submit']){
            if(empty($nom)) $error="Nom laissé vide!";
            elseif(empty($prenom)) $error="Prénom laissé vide!";
            elseif(empty($email)) $error="Le mail laissé vide!";
            elseif(empty($password)) $error="Le mot de passe laissé vide!";
            elseif($password!=$passwordVerified) $error="Mots de passe non identiques!";
            else {
                $userTable->setInfosRegister([
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            ob_start();
            require __DIR__ . '/../Mail/welcome.php';
            $templateHtml = ob_get_clean();

            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = $_ENV['DB_USERNAME'];
                $mail->Password   = $_ENV['DB_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('ismail.zamouri3@gmail.com', 'BudgetTracker');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Bienvenue sur BudgetTracker !';
                $mail->Body    = $templateHtml;
                $mail->send();
            } catch (Exception $e) {
                // Email échoue silencieusement, on redirige quand même
            }
            header('Location: index.php?p=login');
            exit();
            }
        }
    }
    require __DIR__ . '/../../../view/pages/register.php';
    }
}
