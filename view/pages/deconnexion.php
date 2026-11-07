<?php
use App\Format as F;
/** @var float $sold */
/** @var int $transactionCount */
/** @var array $summary */
$user = $_SESSION['user'] ?? null;
$monthLabel = F::monthName($summary['month']);
ob_start();
?>
<div class="title-row">
    <div class="title-block">
        <h1>Se déconnecter</h1>
        <p class="title-sub">Le carnet de <?= F::e($user->username ?? 'votre compte') ?> reste enregistré ; vous le retrouverez à la prochaine connexion.</p>
    </div>
</div>
<div class="leave-grid">
    <section class="card leave" aria-labelledby="leave-title">
        <h2 id="leave-title" class="card-title">Quitter le carnet sur cet appareil</h2>
        <p>Sur un ordinateur partagé, pensez à vous déconnecter après chaque visite&nbsp;: la prochaine personne arrivera sur la page de connexion.</p>
        <form method="POST" action="index.php?p=deconnexion" class="actions">
            <a href="index.php?p=home" class="btn btn-secondary">Rester connecté</a>
            <button type="submit" class="btn btn-primary"><svg class="i" aria-hidden="true"><use href="#i-logout"/></svg>Se déconnecter</button>
        </form>
    </section>
    <section class="card leave" aria-labelledby="state-title">
        <h2 id="state-title" class="card-title">Le carnet tel que vous le laissez</h2>
        <dl class="kv">
            <div><dt>Solde du carnet</dt><dd class="num"><?= F::money($sold) ?></dd></div>
            <div><dt>Reste en <?= $monthLabel ?></dt><dd class="num <?= $summary['left'] < 0 ? 'is-negative' : '' ?>"><?= F::money($summary['left']) ?></dd></div>
            <div><dt>Opérations enregistrées</dt><dd class="num"><?= $transactionCount ?></dd></div>
        </dl>
        <a href="index.php?p=home&amp;export=csv" class="btn btn-secondary"><svg class="i" aria-hidden="true"><use href="#i-download"/></svg>Garder une copie en CSV</a>
    </section>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../template/layout.php';
