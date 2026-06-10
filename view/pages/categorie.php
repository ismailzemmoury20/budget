<?php
/** @var array $categoriesMontant */
ob_start()
?>

<div class="categories-container">
    <div class="categories-header">
        <h2>Mes catégories</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategorieModal">
            + Ajouter une catégorie
        </button>
    </div>

    <div class="table-responsive-wrapper">
    <table class="table table-dark table-hover mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Catégorie</th>
                <th>Type</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categoriesMontant as $cat): ?>
            <tr>
                <td><?= $cat->id ?></td>
                <td><?= $cat->nom ?></td>
                <td>
                    <span class="badge <?= $cat->type === 'revenu' ? 'bg-success' : 'bg-danger' ?>">
                        <?= ucfirst($cat->type) ?>
                    </span>
                </td>
                <td><?= number_format($cat->total ?? 0, 2, ',', ' ') ?> €</td>
                <td>
                    <button class="btn btn-sm btn-outline-warning btn-edit"
                        data-bs-toggle="modal"
                        data-bs-target="#editCategorieModal"
                        data-id="<?= $cat->id ?>"
                        data-nom="<?= $cat->nom ?>"
                        data-type="<?= $cat->type ?>">Modifier
                    </button>

                    <button class="btn btn-sm btn-outline-danger btn-delete"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteCategorieModal"
                        data-id="<?= $cat->id ?>"
                        data-nom="<?= $cat->nom ?>">Supprimer
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <!-- Modal ajout catégorie -->
    <div class="modal fade" id="addCategorieModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Type</label>
                            <select name="type" class="form-select">
                                <option value="revenu">Revenu</option>
                                <option value="depense">Dépense</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Modifier -->
    <div class="modal fade" id="editCategorieModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">Modifier la catégorie</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="nom" id="edit_nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <select name="type" id="edit_type" class="form-select">
                            <option value="revenu">Revenu</option>
                            <option value="depense">Dépense</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Supprimer -->
    <div class="modal fade" id="deleteCategorieModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Supprimer la catégorie</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong id="delete_nom"></strong> ?</p>
                <p class="text-danger small">Cette action est irréversible.</p>
                <form method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="delete_id">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger w-50">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</div>

<script src="js/categorie.js"></script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../template/layout.php';