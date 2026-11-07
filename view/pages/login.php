<?php
/** @var string|null $error */
$authTitle = 'Connexion';
$authQuoteA = 'Votre carnet';
$authQuoteB = 'vous attend.';
require __DIR__ . '/../partials/auth-head.php';
?>
<div class="auth">
    <?php require __DIR__ . '/../partials/auth-side.php'; ?>
    <main class="auth-main">
        <form method="POST" action="index.php?p=login" class="auth-form">
            <h1>Connexion</h1>
            <p class="lead">Retrouvez votre solde et vos opérations là où vous les avez laissés.</p>
            <?php if (!empty($error)): ?>
                <p class="notice notice-error" role="alert"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div class="field">
                <label for="email">E-mail</label>
                <input class="input" type="email" id="email" name="username" autocomplete="email" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="password">
                    <input class="input" type="password" id="password" name="password" autocomplete="current-password" required>
                    <button type="button" data-toggle-password="password" aria-label="Afficher le mot de passe"><svg class="i" aria-hidden="true"><use href="#i-eye"/></svg></button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
            <p class="auth-alt">Pas encore de carnet&nbsp;? <a href="index.php?p=register">Créer un compte</a></p>
        </form>
    </main>
</div>
<script src="js/register.js"></script>
</body>
</html>
