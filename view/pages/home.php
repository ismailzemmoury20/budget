<?php
use App\Format as F;
use App\App;
/** @var array $summary */
/** @var bool $isCurrentMonth */
/** @var float $sold */
/** @var float $totalRevenu */
/** @var float $totalDepense */
/** @var int $transactionCount */
/** @var string $prev */
/** @var string $next */

$monthLabel = F::monthName($summary['month']);
$monthTitle = ucfirst($monthLabel) . ' ' . $summary['year'];
$income = $summary['income'];
$expense = $summary['expense'];
$left = $summary['left'];

// Jours restants (mois en cours seulement), aujourd'hui compris
$today = (int) date('j');
$daysLeft = $isCurrentMonth ? $summary['days'] - $today + 1 : 0;
$perDayLeft = ($isCurrentMonth && $left > 0) ? floor($left / $daysLeft * 100) / 100 : null;

// Le constat du mois, en une phrase
$top = $summary['perCategory'][0] ?? null;
if ($expense == 0 && $income == 0) {
    $finding = "Aucune opération en $monthLabel pour l'instant.";
} elseif ($left < 0) {
    $finding = 'Vous avez dépensé ' . F::money(-$left) . " de plus que vos revenus de $monthLabel.";
} elseif ($top) {
    $share = $expense > 0 ? round($top['total'] / $expense * 100) : 0;
    $finding = $top['nom'] . ' : ' . F::money($top['total']) . ", soit $share % de vos dépenses de $monthLabel.";
} else {
    $finding = "Aucune dépense en $monthLabel pour l'instant.";
}

// Graphique « le mois jour par jour » : échelle ronde au-dessus du maximum
$maxDay = max($summary['perDay'] ?: [0]);
$steps = [10, 20, 25, 50, 100, 200, 250, 500, 1000, 2000, 2500, 5000];
$step = 10;
foreach ($steps as $s) { if ($maxDay / $s <= 4) { $step = $s; break; } }
$top4 = $step * max(1, (int) ceil(($maxDay ?: 1) / $step));
if ($top4 <= $maxDay) $top4 += $step;
$ticks = range(0, $top4, $step);

// La plus grosse dépense du mois est annotée sur son jour
$peakDay = $maxDay > 0 ? array_search($maxDay, $summary['perDay']) : null;
$peakLabel = null;
if ($peakDay) {
    foreach ($summary['rows'] as $r) {
        if ($r->type === 'depense' && (int) date('j', strtotime($r->date)) === $peakDay) { $peakLabel = $r->description ?: $r->categorie_nom; break; }
    }
}

$recent = array_slice($summary['rows'], 0, 5);
$cats = array_slice($summary['perCategory'], 0, 5);
$maxCat = $cats ? $cats[0]['total'] : 0;
$spentPct = $income > 0 ? min(100, $expense / $income * 100) : ($expense > 0 ? 100 : 0);

// Arbre des catégories (tous mois confondus)
$allCats = App::getInstance()->getTable('categorie')->getTotalByCategorie();
$catRevenus = array_values(array_filter($allCats, fn($c) => $c->type === 'revenu'));
$catDepenses = array_values(array_filter($allCats, fn($c) => $c->type === 'depense'));

ob_start();
?>
<div class="title-row">
    <div class="title-block">
        <div class="month-switch">
            <a class="btn btn-ghost btn-icon" href="index.php?p=home&amp;m=<?= $prev ?>" aria-label="Mois précédent"><svg class="i" aria-hidden="true"><use href="#i-left"/></svg></a>
            <h1><?= $monthTitle ?></h1>
            <a class="btn btn-ghost btn-icon" href="index.php?p=home&amp;m=<?= $next ?>" aria-label="Mois suivant"><svg class="i" aria-hidden="true"><use href="#i-right"/></svg></a>
        </div>
        <p class="title-sub"><?= F::e($finding) ?></p>
    </div>
    <div class="title-actions">
        <a href="index.php?p=home&amp;export=csv" class="btn btn-secondary"><svg class="i" aria-hidden="true"><use href="#i-download"/></svg>Exporter en CSV</a>
        <a href="index.php?p=add" class="btn btn-primary"><svg class="i" aria-hidden="true"><use href="#i-plus"/></svg>Nouvelle transaction</a>
    </div>
</div>

<div class="home-grid">
    <!-- Colonne fixe : le solde du carnet et ses catégories -->
    <section class="card ledger" aria-labelledby="ledger-title">
        <div class="ledger-head">
            <h2 id="ledger-title" class="card-title">Solde du carnet</h2>
            <p class="ledger-balance num <?= $sold < 0 ? 'is-negative' : '' ?>"><?= F::money($sold) ?></p>
            <p class="meta"><?= $transactionCount ?> opération<?= $transactionCount > 1 ? 's' : '' ?> enregistrée<?= $transactionCount > 1 ? 's' : '' ?></p>
        </div>
        <div class="tree">
            <div class="tree-group">
                <div class="tree-row tree-head"><span>Revenus</span><span class="num amount-in"><?= F::money($totalRevenu, true) ?></span></div>
                <?php if (!$catRevenus): ?>
                    <a class="tree-empty" href="index.php?p=categorie">+ Ajouter une catégorie de revenus</a>
                <?php endif; ?>
                <?php foreach ($catRevenus as $c): ?>
                    <div class="tree-row"><span class="tree-name"><span class="dot <?= F::tint($c->id) ?>"></span><?= F::e($c->nom) ?></span><span class="num"><?= $c->total > 0 ? F::money($c->total) : '<span class="dash">—</span>' ?></span></div>
                <?php endforeach; ?>
            </div>
            <div class="tree-group">
                <div class="tree-row tree-head"><span>Dépenses</span><span class="num"><?= F::money($totalDepense) ?></span></div>
                <?php if (!$catDepenses): ?>
                    <a class="tree-empty" href="index.php?p=categorie">+ Ajouter une catégorie de dépenses</a>
                <?php endif; ?>
                <?php foreach ($catDepenses as $c): ?>
                    <div class="tree-row"><span class="tree-name"><span class="dot <?= F::tint($c->id) ?>"></span><?= F::e($c->nom) ?></span><span class="num"><?= $c->total > 0 ? F::money($c->total) : '<span class="dash">—</span>' ?></span></div>
                <?php endforeach; ?>
            </div>
        </div>
        <a class="card-link" href="index.php?p=categorie">Gérer les catégories <svg class="i" aria-hidden="true"><use href="#i-arrow"/></svg></a>
    </section>

    <div class="month-grid">
        <!-- La question de l'écran : combien reste-t-il ce mois-ci ? -->
        <section class="card month span-2" aria-labelledby="month-title">
            <div class="card-head">
                <h2 id="month-title" class="card-title">Reste en <?= $monthLabel ?></h2>
                <span class="meta">du 1<sup>er</sup> au <?= $summary['days'] ?> <?= $monthLabel ?></span>
            </div>
            <div class="month-figures">
                <div class="lead-figure">
                    <?php [$int, $cents] = F::moneyParts($left); ?>
                    <p class="lead num <?= $left < 0 ? 'is-negative' : '' ?>"><?= $int ?><span class="cents"><?= $cents ?></span></p>
                    <p class="meta">
                        <?php if ($perDayLeft !== null): ?>
                            soit <span class="num ink"><?= F::money($perDayLeft) ?></span> par jour pendant les <?= $daysLeft ?> jours qui restent
                        <?php elseif ($isCurrentMonth && $left <= 0 && ($income > 0 || $expense > 0)): ?>
                            dépenses supérieures aux revenus du mois
                        <?php else: ?>
                            revenus moins dépenses du mois
                        <?php endif; ?>
                    </p>
                </div>
                <dl class="pair">
                    <div><dt>Revenus du mois</dt><dd class="num amount-in"><?= F::money($income, true) ?></dd></div>
                    <div><dt>Dépenses du mois</dt><dd class="num"><?= F::money($expense) ?></dd></div>
                </dl>
            </div>
            <div class="gauge" role="img" aria-label="<?= round($spentPct) ?> % des revenus du mois déjà dépensés">
                <div class="gauge-track"><div class="gauge-fill" style="width: <?= round($spentPct, 1) ?>%"></div></div>
                <div class="gauge-legend"><span><span class="swatch swatch-spent"></span><?= round($spentPct) ?> % des revenus dépensés</span><span class="num"><?= F::money($expense) ?> sur <?= F::money($income) ?></span></div>
            </div>

            <figure class="days" aria-labelledby="days-title">
                <figcaption id="days-title" class="days-title">Dépenses jour par jour</figcaption>
                <div class="days-plot" style="--top: <?= $top4 ?>">
                    <div class="days-grid" aria-hidden="true">
                        <?php foreach (array_reverse($ticks) as $t): ?>
                            <span class="tick" style="--v: <?= $t ?>"><span class="num"><?= number_format($t, 0, ',', "\u{202F}") ?></span></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="days-bars">
                        <?php foreach ($summary['perDay'] as $d => $v): ?>
                            <div class="day<?= $isCurrentMonth && $d === $today ? ' is-today' : '' ?><?= $isCurrentMonth && $d > $today ? ' is-future' : '' ?>" style="--v: <?= round($v, 2) ?>">
                                <span class="bar" title="<?= $d ?> <?= $monthLabel ?> : <?= F::money($v) ?>"></span>
                                <?php if ($d === $peakDay && $peakLabel): ?><span class="peak"><span class="peak-name"><?= F::e($peakLabel) ?> </span><span class="num"><?= F::money($v) ?></span></span><?php endif; ?>
                                <?php $isToday = $isCurrentMonth && $d === $today; $nearToday = $isCurrentMonth && !$isToday && abs($d - $today) <= 2; ?>
                                <?php if ($isToday || (!$nearToday && ($d === 1 || $d % 5 === 0))): ?><span class="dlabel num"><?= $isCurrentMonth && $d === $today ? "Aujourd'hui" : $d ?></span><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </figure>
        </section>

        <!-- Les dernières opérations -->
        <section class="card" aria-labelledby="recent-title">
            <div class="card-head">
                <h2 id="recent-title" class="card-title">Dernières opérations</h2>
                <span class="meta"><?= count($summary['rows']) ?> en <?= $monthLabel ?></span>
            </div>
            <?php if (!$recent): ?>
                <div class="empty">Aucune opération en <?= $monthLabel ?>. <a href="index.php?p=add">Ajouter la première</a></div>
            <?php else: ?>
                <ul class="rows">
                    <?php foreach ($recent as $tx): ?>
                        <li class="row">
                            <span class="tile <?= F::tint($tx->categorie_id) ?>" aria-hidden="true"><?= F::initial($tx->categorie_nom ?? $tx->description) ?></span>
                            <span class="row-main">
                                <span class="row-title"><?= F::e($tx->description ?: 'Sans description') ?></span>
                                <span class="row-sub"><?= F::e($tx->categorie_nom ?? 'Sans catégorie') ?></span>
                            </span>
                            <span class="row-figure">
                                <span class="num <?= $tx->type === 'revenu' ? 'amount-in' : '' ?>"><?= $tx->type === 'revenu' ? F::money($tx->montant, true) : F::money($tx->montant) ?></span>
                                <span class="row-sub"><?= F::shortDate($tx->date) ?></span>
                            </span>
                            <span class="row-actions">
                                <button type="button" class="btn btn-ghost btn-icon" aria-label="Modifier « <?= F::e($tx->description ?: 'Sans description') ?> »"
                                    data-open="editTx" data-id="<?= $tx->id ?>" data-montant="<?= $tx->montant ?>" data-description="<?= F::e($tx->description) ?>" data-type="<?= $tx->type ?>" data-date="<?= $tx->date ?>"><svg class="i" aria-hidden="true"><use href="#i-pencil"/></svg></button>
                                <button type="button" class="btn btn-ghost btn-icon" aria-label="Supprimer « <?= F::e($tx->description ?: 'Sans description') ?> »"
                                    data-open="deleteTx" data-id="<?= $tx->id ?>" data-label="<?= F::e($tx->description ?: 'cette opération') ?>"><svg class="i" aria-hidden="true"><use href="#i-trash"/></svg></button>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <!-- Où part l'argent ce mois-ci -->
        <section class="card" aria-labelledby="cats-title">
            <div class="card-head">
                <h2 id="cats-title" class="card-title">Dépenses par catégorie</h2>
                <span class="meta"><?= $monthLabel ?></span>
            </div>
            <?php if (!$cats): ?>
                <div class="empty">Aucune dépense en <?= $monthLabel ?>.</div>
            <?php else: ?>
                <ul class="rows">
                    <?php foreach ($cats as $c): ?>
                        <li class="row">
                            <span class="tile <?= F::tint($c['id']) ?>" aria-hidden="true"><?= F::initial($c['nom']) ?></span>
                            <span class="row-main">
                                <span class="row-title"><?= F::e($c['nom']) ?></span>
                                <span class="share" aria-hidden="true"><span style="width: <?= $maxCat > 0 ? round($c['total'] / $maxCat * 100, 1) : 0 ?>%"></span></span>
                            </span>
                            <span class="row-figure">
                                <span class="num"><?= F::money($c['total']) ?></span>
                                <span class="row-sub num"><?= $expense > 0 ? round($c['total'] / $expense * 100) : 0 ?> %</span>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </div>
</div>

<dialog id="editTx" class="dialog" aria-labelledby="editTx-title">
    <form method="POST" action="index.php?p=home&amp;m=<?= sprintf('%04d-%02d', $summary['year'], $summary['month']) ?>" class="dialog-body">
        <h2 id="editTx-title" class="card-title">Modifier l'opération</h2>
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" data-fill="id">
        <div class="field"><label for="edit-montant">Montant (€)</label><input class="input num" type="number" step="0.01" min="0" id="edit-montant" name="montant" data-fill="montant" required></div>
        <div class="field"><label for="edit-description">Description</label><input class="input" type="text" id="edit-description" name="description" data-fill="description"></div>
        <div class="field-pair">
            <div class="field"><label for="edit-type">Type</label><select class="input" id="edit-type" name="type" data-fill="type"><option value="depense">Dépense</option><option value="revenu">Revenu</option></select></div>
            <div class="field"><label for="edit-date">Date</label><input class="input" type="date" id="edit-date" name="date" data-fill="date" required></div>
        </div>
        <div class="dialog-actions">
            <button type="button" class="btn btn-secondary" data-close>Annuler</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</dialog>

<dialog id="deleteTx" class="dialog" aria-labelledby="deleteTx-title">
    <form method="POST" action="index.php?p=home&amp;m=<?= sprintf('%04d-%02d', $summary['year'], $summary['month']) ?>" class="dialog-body">
        <h2 id="deleteTx-title" class="card-title">Supprimer « <span data-fill="label"></span> » ?</h2>
        <p class="hint">L'opération disparaît du carnet et le solde est recalculé. Cette action ne peut pas être annulée.</p>
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="id" data-fill="id">
        <div class="dialog-actions">
            <button type="button" class="btn btn-secondary" data-close>Annuler</button>
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </div>
    </form>
</dialog>
<?php
$content = ob_get_clean();
require __DIR__ . '/../template/layout.php';
