<?php
/** @var string|null $success */
/** @var string|null $error */
/** @var array $categorie */
ob_start();
?>

<div class="transaction-container">
    <div class="title">
        <h2>Ajouter une transaction</h2>
        <p>Remplissez les détails ci-dessous pour enregistrer une nouvelle entrée</p>
    </div>

    <?php if($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="type" id="type" value="revenu">

        <div class="bouton-transactions">
            <p>TYPE DE TRANSACTION</p>
            <div class="buttons">
                <button type="button" id="btn-revenu" class="btn btn-outline-primary active" onclick="setType('revenu')">Revenu</button>
                <button type="button" id="btn-depense" class="btn btn-outline-danger" onclick="setType('depense')">Dépense</button>
            </div>
        </div>

        <div class="montant">
            <p>MONTANT</p>
            <input name="montant" type="number" step="0.01" class="form-control" placeholder="0.00" required>
        </div>

        <div class="description">
            <p>DESCRIPTION</p>
            <input name="description" type="text" class="form-control" placeholder="Ex : Salaire mensuel, courses…">
        </div>

        <div class="category-container">
            <div class="category">
                <p>CATÉGORIE</p>
                <select class="form-select" name="categorie_id">
                    <option value="">Sélectionnez une catégorie</option>
                    <?php foreach($categorie as $cat): ?>
                        <option value="<?= $cat->id ?>"><?= $cat->nom ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="date">
                <p>DATE</p>
                <input name="date" type="date" class="form-control" required>
            </div>
        </div>

        <div class="notes">
            <p>NOTES (FACULTATIF)</p>
            <textarea name="notes" class="form-control" rows="3" placeholder="Ajoutez des informations complémentaires…"></textarea>
        </div>

        <button class="submit" type="submit">Enregistrer la transaction</button>
    </form>
</div>

<script src="js/add.js"></script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../template/layout.php';
?>
