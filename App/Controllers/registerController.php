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
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordVerified = $_POST['password_confirm'] ?? '';

        if($_POST['submit']){
            if(empty($username)) $error="Nom d'utilisateur laissé vide!";
            elseif(empty($email)) $error="Le mail laissé vide!";
            elseif(empty($password)) $error="Le mot de passe laissé vide!";
            elseif($password!=$passwordVerified) $error="Mots de passe non identiques!";
            else {
                $userTable->setInfosRegister([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            ob_start();
            require __DIR__ . '/../../App/Mail/welcome.php';
            $templateHtml = ob_get_clean();

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
            header('Location: index.php?p=login');
            exit();
            }
        }
    }
    require __DIR__ . '/../../view/pages/register.php';
    }
}
