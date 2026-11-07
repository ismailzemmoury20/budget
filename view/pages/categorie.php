<?php
use App\Format as F;
/** @var array $categoriesMontant */
/** @var array $monthByCat */
/** @var string $monthLabel */
$groups = [
    'depense' => ['Dépenses', array_values(array_filter($categoriesMontant, fn($c) => $c->type === 'depense'))],
    'revenu'  => ['Revenus', array_values(array_filter($categoriesMontant, fn($c) => $c->type === 'revenu'))],
];
$count = count($categoriesMontant);
ob_start();
?>
<div class="title-row">
    <div class="title-block">
        <h1>Catégories</h1>
        <p class="title-sub"><?= $count ?> catégorie<?= $count > 1 ? 's' : '' ?> : <?= count($groups['depense'][1]) ?> de dépenses, <?= count($groups['revenu'][1]) ?> de revenus.</p>
    </div>
</div>

<div class="cat-grid">
    <section class="card" aria-labelledby="cat-table-title">
        <h2 id="cat-table-title" class="sr-only">Toutes les catégories</h2>
        <?php if (!$categoriesMontant): ?>
            <div class="empty">Aucune catégorie pour l'instant. Créez la première avec le formulaire.</div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Catégorie</th>
                    <th scope="col" class="num">Opérations</th>
                    <th scope="col" class="num hide-phone">En <?= $monthLabel ?></th>
                    <th scope="col" class="num">Total</th>
                    <th scope="col" class="actions"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <?php foreach ($groups as $type => [$label, $list]): if (!$list) continue; ?>
            <tbody>
                <tr class="group"><td colspan="5"><?= $label ?></td></tr>
                <?php foreach ($list as $cat): $m = $monthByCat[(int) $cat->id] ?? 0; ?>
                <tr>
                    <td><span class="name"><span class="tile <?= F::tint($cat->id) ?>" aria-hidden="true"><?= F::initial($cat->nom) ?></span><?= F::e($cat->nom) ?></span></td>
                    <td class="num"><?= (int) $cat->nb ?></td>
                    <td class="num hide-phone"><?= $m > 0 ? ($type === 'revenu' ? '<span class="amount-in">' . F::money($m, true) . '</span>' : F::money($m)) : '<span class="dash">—</span>' ?></td>
                    <td class="num"><?= $cat->total > 0 ? ($type === 'revenu' ? '<span class="amount-in">' . F::money($cat->total, true) . '</span>' : F::money($cat->total)) : '<span class="dash">—</span>' ?></td>
                    <td class="actions">
                        <button type="button" class="btn btn-ghost btn-icon" aria-label="Modifier « <?= F::e($cat->nom) ?> »" data-open="editCat" data-id="<?= $cat->id ?>" data-nom="<?= F::e($cat->nom) ?>" data-type="<?= $cat->type ?>"><svg class="i" aria-hidden="true"><use href="#i-pencil"/></svg></button>
                        <button type="button" class="btn btn-ghost btn-icon" aria-label="Supprimer « <?= F::e($cat->nom) ?> »" data-open="deleteCat" data-id="<?= $cat->id ?>" data-label="<?= F::e($cat->nom) ?>" data-nb="<?= (int) $cat->nb ?>"><svg class="i" aria-hidden="true"><use href="#i-trash"/></svg></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </section>

    <section class="card form-card" aria-labelledby="new-cat-title">
        <h2 id="new-cat-title" class="card-title">Nouvelle catégorie</h2>
        <form method="POST" action="index.php?p=categorie" class="form-card">
            <input type="hidden" name="action" value="add">
            <div class="field">
                <label for="new-nom">Nom</label>
                <input class="input" type="text" id="new-nom" name="nom" placeholder="Loyer, Salaire, Vacances…" required maxlength="100">
            </div>
            <fieldset class="field" style="border:0;padding:0;margin:0">
                <legend class="label" style="margin-bottom:8px">Type</legend>
                <div class="segmented">
                    <input type="radio" name="type" id="new-depense" value="depense" checked><label for="new-depense">Dépense</label>
                    <input type="radio" name="type" id="new-revenu" value="revenu"><label for="new-revenu">Revenu</label>
                </div>
            </fieldset>
            <div class="form-foot"><button type="submit" class="btn btn-primary">Créer la catégorie</button></div>
        </form>
    </section>
</div>

<dialog id="editCat" class="dialog" aria-labelledby="editCat-title">
    <form method="POST" action="index.php?p=categorie" class="dialog-body">
        <h2 id="editCat-title" class="card-title">Modifier la catégorie</h2>
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" data-fill="id">
        <div class="field"><label for="edit-nom">Nom</label><input class="input" type="text" id="edit-nom" name="nom" data-fill="nom" required maxlength="100"></div>
        <div class="field"><label for="edit-type">Type</label><select class="input" id="edit-type" name="type" data-fill="type"><option value="depense">Dépense</option><option value="revenu">Revenu</option></select></div>
        <div class="dialog-actions">
            <button type="button" class="btn btn-secondary" data-close>Annuler</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</dialog>

<dialog id="deleteCat" class="dialog" aria-labelledby="deleteCat-title">
    <form method="POST" action="index.php?p=categorie" class="dialog-body">
        <h2 id="deleteCat-title" class="card-title">Supprimer « <span data-fill="label"></span> » ?</h2>
        <p class="hint">Ses <span data-fill="nb"></span> opération(s) restent dans le carnet, classées « Sans catégorie ». Cette action ne peut pas être annulée.</p>
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
