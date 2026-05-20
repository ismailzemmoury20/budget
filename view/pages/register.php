<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Budget — Créer un compte</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">

            <div class="register-header">
                <div class="login-logo">BUDGET</div>
                <h2 class="login-title">Créer un compte</h2>
                <p class="login-subtitle">Rejoignez-nous et prenez le contrôle de vos finances</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="login-error">
                    <i class="ri-error-warning-line"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="index.php?p=register" method="POST">

                <div class="field">
                    <label>NOM D'UTILISATEUR</label>
                    <input type="text" name="username" class="form-control" placeholder="Jean Dupont" required>
                </div>

                <div class="field">
                    <label>EMAIL</label>
                    <input type="email" name="email" class="form-control" placeholder="votre@email.com" required>
                </div>

                <div class="field">
                    <label>MOT DE PASSE</label>
                    <div class="password-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <p class="strength-label" id="strengthLabel"></p>
                </div>

                <div class="field">
                    <label>CONFIRMER LE MOT DE PASSE</label>
                    <div class="password-wrapper">
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="••••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirm', this)">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" name="submit" value="1" class="login-btn">
                    <i class="ri-user-add-line"></i> Créer mon compte
                </button>

                <div class="register-divider">ou</div>

                <p class="login-link">
                    Déjà un compte ? <a href="index.php?p=login">Se connecter</a>
                </p>

            </form>
            <a href="index.php?p=landing" class="login-back-link">
                <i class="ri-arrow-left-line"></i> Retour à l'accueil
            </a>
        </div>
    </div>

    <script src="js/register.js"></script>
</body>
</html>
