<?php
/** @var string|null $error */
$authTitle = 'Créer un compte';
$authQuoteA = 'Un carnet,';
$authQuoteB = 'trois champs.';
require __DIR__ . '/../partials/auth-head.php';
?>
<div class="auth">
    <?php require __DIR__ . '/../partials/auth-side.php'; ?>
    <main class="auth-main">
        <form action="index.php?p=register" method="POST" class="auth-form">
            <h1>Créer un compte</h1>
            <p class="lead">Votre carnet est prêt dès l'inscription&nbsp;; ajoutez ensuite vos catégories et vos premières opérations.</p>
            <?php if (!empty($error)): ?>
                <p class="notice notice-error" role="alert"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <div class="field">
                <label for="username">Nom</label>
                <input class="input" type="text" id="username" name="username" autocomplete="name" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="email">E-mail</label>
                <input class="input" type="email" id="email" name="email" autocomplete="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="password">Mot de passe</label>
                <div class="password">
                    <input class="input" type="password" id="password" name="password" autocomplete="new-password" aria-describedby="strength-text" required>
                    <button type="button" data-toggle-password="password" aria-label="Afficher le mot de passe"><svg class="i" aria-hidden="true"><use href="#i-eye"/></svg></button>
                </div>
                <div class="strength">
                    <div class="strength-track"><div class="strength-fill" id="strengthFill"></div></div>
                    <p id="strength-text">8 caractères ou plus, avec une majuscule, un chiffre et un symbole pour un mot de passe solide.</p>
                </div>
            </div>
            <div class="field">
                <label for="password_confirm">Confirmer le mot de passe</label>
                <div class="password">
                    <input class="input" type="password" id="password_confirm" name="password_confirm" autocomplete="new-password" required>
                    <button type="button" data-toggle-password="password_confirm" aria-label="Afficher le mot de passe"><svg class="i" aria-hidden="true"><use href="#i-eye"/></svg></button>
                </div>
            </div>
            <button type="submit" name="submit" value="1" class="btn btn-primary">Créer mon carnet</button>
            <p class="auth-alt">Déjà un compte&nbsp;? <a href="index.php?p=login">Se connecter</a></p>
        </form>
    </main>
</div>
<script src="js/register.js"></script>
</body>
</html>
