<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Budget — Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo">BUDGET</div>
            <h2 class="login-title">Connexion</h2>
            <p class="login-subtitle">Accédez à votre espace personnel</p>

            <?php if (!empty($error)): ?>
                <div class="login-error">
                    <i class="ri-error-warning-line"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?p=login">
                <div class="field">
                    <label>EMAIL</label>
                    <input type="email" name="username" class="form-control" placeholder="votre@email.com" required>
                </div>
                <div class="field">
                    <label>MOT DE PASSE</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="login-btn">
                    <i class="ri-login-circle-line"></i> Se connecter
                </button>
            </form>
            <a href="index.php?p=register" class="login-btn" style="display:flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;margin-top:12px;background:transparent;border:1px solid var(--border);color:var(--text-muted);">
                <i class="ri-user-add-line"></i> Créer un compte
            </a>
            <a href="index.php?p=landing" class="login-back-link">
                <i class="ri-arrow-left-line"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
