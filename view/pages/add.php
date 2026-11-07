<?php
use App\Format as F;
/** @var string|null $success */
/** @var string|null $error */
/** @var array $categorie */
/** @var array $summary */
$monthLabel = F::monthName($summary['month']);
$catsJson = array_map(fn($c) => ['id' => (int) $c->id, 'nom' => $c->nom, 'type' => $c->type, 'tint' => F::tint($c->id)], $categorie);
ob_start();
?>
<div class="title-row">
    <div class="title-block">
        <h1>Nouvelle transaction</h1>
        <p class="title-sub">Une ligne de plus dans le carnet : le reste de <?= $monthLabel ?> est recalculé aussitôt.</p>
    </div>
</div>

<div class="form-grid">
    <form method="POST" action="index.php?p=add" class="card form-card" id="txForm" novalidate>
        <?php if ($success): ?><p class="notice notice-success" role="status"><?= F::e($success) ?></p><?php endif; ?>
        <?php if ($error): ?><p class="notice notice-error" role="alert"><?= F::e($error) ?></p><?php endif; ?>

        <div class="quick">
            <label for="quick">Saisie rapide</label>
            <input class="input" type="text" id="quick" autocomplete="off" placeholder="Courses 52,17" aria-describedby="quick-hint">
            <p class="hint" id="quick-hint">Un libellé et un montant suffisent ; « + » devant le montant pour un revenu. Les champs ci-dessous se remplissent.</p>
        </div>

        <fieldset class="field" style="border:0;padding:0;margin:0">
            <legend class="label" style="margin-bottom:8px">Type</legend>
            <div class="segmented">
                <input type="radio" name="type" id="type-depense" value="depense" checked><label for="type-depense">Dépense</label>
                <input type="radio" name="type" id="type-revenu" value="revenu"><label for="type-revenu">Revenu</label>
            </div>
        </fieldset>

        <div class="field">
            <label for="montant">Montant</label>
            <div class="amount-input">
                <input class="input num" type="text" inputmode="decimal" name="montant" id="montant" placeholder="0,00" required>
                <span class="unit" aria-hidden="true">€</span>
            </div>
        </div>

        <div class="field">
            <label for="description">Description</label>
            <input class="input" type="text" name="description" id="description" placeholder="Marché d'Aligre, salaire de novembre…">
        </div>

        <div class="field-pair">
            <div class="field">
                <label for="categorie_id">Catégorie</label>
                <select class="input" name="categorie_id" id="categorie_id">
                    <option value="">Sans catégorie</option>
                    <?php foreach ($categorie as $cat): ?>
                        <option value="<?= $cat->id ?>" data-type="<?= $cat->type ?>"><?= F::e($cat->nom) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field">
                <label for="date">Date</label>
                <input class="input" type="date" name="date" id="date" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <div class="field">
            <label for="notes">Notes <span class="meta">(facultatif)</span></label>
            <textarea class="input" name="notes" id="notes" rows="3" placeholder="Numéro de facture, avec qui…"></textarea>
        </div>

        <div class="form-foot">
            <a href="index.php?p=home" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer l'opération</button>
        </div>
    </form>

    <aside class="side-stack">
        <section class="card preview" aria-labelledby="preview-title">
            <div class="card-head" style="margin-bottom:0">
                <h2 id="preview-title" class="card-title">Aperçu</h2>
                <span class="meta">dans « Dernières opérations »</span>
            </div>
            <ul class="rows" data-ui>
                <li class="row" style="grid-template-columns:36px minmax(0,1fr) auto">
                    <span class="tile tint-none" id="pvTile" aria-hidden="true">–</span>
                    <span class="row-main">
                        <span class="row-title" id="pvTitle">Sans description</span>
                        <span class="row-sub" id="pvCat">Sans catégorie</span>
                    </span>
                    <span class="row-figure">
                        <span class="num" id="pvAmount">0,00&nbsp;€</span>
                        <span class="row-sub" id="pvDate">Aujourd'hui</span>
                    </span>
                </li>
            </ul>
            <div class="impact" aria-live="polite">
                <div class="impact-row"><span class="meta">Reste en <?= $monthLabel ?> aujourd'hui</span><span class="num" id="pvBefore"><?= F::money($summary['left']) ?></span></div>
                <div class="impact-row"><span class="meta">Cette opération</span><span class="num" id="pvDelta">—</span></div>
                <div class="impact-row impact-after"><span>Après enregistrement</span><span class="num" id="pvAfter"><?= F::money($summary['left']) ?></span></div>
                <p class="hint" id="pvNote"></p>
            </div>
        </section>
        <section class="card" aria-labelledby="recent-add-title">
            <div class="card-head">
                <h2 id="recent-add-title" class="card-title">Déjà noté en <?= $monthLabel ?></h2>
                <span class="meta"><?= count($summary['rows']) ?> opération<?= count($summary['rows']) > 1 ? 's' : '' ?></span>
            </div>
            <?php $recentAdd = array_slice($summary['rows'], 0, 5); ?>
            <?php if (!$recentAdd): ?>
                <div class="empty">Rien pour l'instant : cette opération sera la première du mois.</div>
            <?php else: ?>
                <ul class="rows">
                    <?php foreach ($recentAdd as $tx): ?>
                        <li class="row" style="grid-template-columns:36px minmax(0,1fr) auto">
                            <span class="tile <?= F::tint($tx->categorie_id) ?>" aria-hidden="true"><?= F::initial($tx->categorie_nom ?? $tx->description) ?></span>
                            <span class="row-main"><span class="row-title"><?= F::e($tx->description ?: 'Sans description') ?></span><span class="row-sub"><?= F::e($tx->categorie_nom ?? 'Sans catégorie') ?></span></span>
                            <span class="row-figure"><span class="num <?= $tx->type === 'revenu' ? 'amount-in' : '' ?>"><?= $tx->type === 'revenu' ? F::money($tx->montant, true) : F::money($tx->montant) ?></span><span class="row-sub"><?= F::shortDate($tx->date) ?></span></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </aside>
</div>

<script>
    window.BUDGET = {
        left: <?= json_encode($summary['left']) ?>,
        month: <?= (int) $summary['month'] ?>,
        year: <?= (int) $summary['year'] ?>,
        monthLabel: <?= json_encode($monthLabel) ?>,
        cats: <?= json_encode($catsJson, JSON_UNESCAPED_UNICODE) ?>
    };
</script>
<script src="js/add.js"></script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../template/layout.php';
