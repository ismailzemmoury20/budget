<?php
/** @var string|null $activeNav */
$user = $_SESSION['user'] ?? null;
$userName = $user->username ?? 'Mon compte';
$userMail = $user->email ?? '';
$nav = [
    'home'      => ['index.php?p=home', 'home', 'Tableau de bord'],
    'add'       => ['index.php?p=add', 'plus', 'Nouvelle transaction'],
    'categorie' => ['index.php?p=categorie', 'tag', 'Catégories'],
];
?>
<aside class="sidebar" id="sidebar" aria-label="Navigation">
    <a href="index.php?p=home" class="brand">
        <?php require __DIR__ . '/logo.php'; ?>
        <span>Budget</span>
    </a>
    <div class="scope">
        <span class="scope-label">Carnet de</span>
        <span class="scope-name"><?= htmlspecialchars($userName) ?></span>
    </div>
    <nav class="nav">
        <?php foreach ($nav as $key => [$href, $icon, $label]): ?>
            <a href="<?= $href ?>" class="nav-item<?= ($activeNav ?? '') === $key ? ' is-active' : '' ?>"<?= ($activeNav ?? '') === $key ? ' aria-current="page"' : '' ?>>
                <svg class="i" aria-hidden="true"><use href="#i-<?= $icon ?>"/></svg><?= $label ?>
            </a>
        <?php endforeach; ?>
        <a href="index.php?p=home&amp;export=csv" class="nav-item">
            <svg class="i" aria-hidden="true"><use href="#i-download"/></svg>Exporter en CSV
        </a>
    </nav>
    <div class="sidebar-foot">
        <div class="user-row">
            <span class="avatar tint-0" aria-hidden="true"><?= htmlspecialchars(mb_strtoupper(mb_substr($userName, 0, 1))) ?></span>
            <span class="user-text">
                <span class="user-name"><?= htmlspecialchars($userName) ?></span>
                <span class="user-mail"><?= htmlspecialchars($userMail) ?></span>
            </span>
        </div>
        <a href="index.php?p=deconnexion" class="nav-item<?= ($activeNav ?? '') === 'deconnexion' ? ' is-active' : '' ?>">
            <svg class="i" aria-hidden="true"><use href="#i-logout"/></svg>Se déconnecter
        </a>
    </div>
</aside>
