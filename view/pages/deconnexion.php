<div class="deconnexion-wrapper">
    <div class="deconnexion-card">
        <div class="deconnexion-icon">
            <i class="ri-logout-circle-r-line"></i>
        </div>
        <h2>Voulez-vous vous déconnecter ?</h2>
        <p>Vous allez quitter votre espace personnel. Vos données restent en sécurité.</p>
        <div class="deconnexion-actions">
            <form method="POST">
                <button type="submit" class="btn-logout">
                    <i class="ri-logout-circle-r-line"></i> Se déconnecter
                </button>
            </form>
            <a href="index.php" class="btn-cancel">
                <i class="ri-arrow-left-line"></i> Annuler
            </a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../template/layout.php';
?>
