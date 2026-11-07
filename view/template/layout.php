<?php
/** @var string $content */
/** @var string|null $pageTitle */
require __DIR__ . '/../partials/header.php';
?>
<div class="shell">
    <header class="phone-bar">
        <a href="index.php?p=home" class="brand"><?php require __DIR__ . '/../partials/logo.php'; ?><span>Budget</span></a>
        <div class="phone-bar-actions">
            <a href="index.php?p=add" class="btn btn-primary btn-icon" aria-label="Nouvelle transaction"><svg class="i" aria-hidden="true"><use href="#i-plus"/></svg></a>
            <button type="button" class="btn btn-secondary btn-icon" id="menuToggle" aria-controls="sidebar" aria-expanded="false" aria-label="Ouvrir le menu"><svg class="i" aria-hidden="true"><use href="#i-menu"/></svg></button>
        </div>
    </header>
    <?php require __DIR__ . '/../partials/sidebar.php'; ?>
    <main class="canvas" id="contenu">
        <?= $content ?>
    </main>
</div>
<script src="js/app.js"></script>
</body>
</html>
