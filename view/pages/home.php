<?php
/** @var float $sold */
/** @var float $totalRevenu */
/** @var float $totalDepense */
/** @var array $transactions */
/** @var array $label */
/** @var array $data */
ob_start();
?>

<!-- ── Stat Cards ── -->
<div class="view-chiffre">
    <div class="stat-card total-solde">
        <div class="stat-icon-wrap stat-icon-solde">
            <i class="ri-wallet-3-line"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">SOLDE ACTUEL</span>
            <h4 class="stat-value <?= $sold < 0 ? 'val-red' : 'val-green' ?>">
                <?= number_format($sold, 2, ',', ' ') ?> €
            </h4>
        </div>
    </div>
    <div class="stat-card total-revenus">
        <div class="stat-icon-wrap stat-icon-revenu">
            <i class="ri-arrow-up-circle-line"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">TOTAL REVENUS</span>
            <h4 class="stat-value val-green">
                <?= number_format($totalRevenu, 2, ',', ' ') ?> €
            </h4>
        </div>
    </div>
    <div class="stat-card total-depense">
        <div class="stat-icon-wrap stat-icon-depense">
            <i class="ri-arrow-down-circle-line"></i>
        </div>
        <div class="stat-info">
            <span class="stat-label">TOTAL DÉPENSES</span>
            <h4 class="stat-value val-red">
                <?= number_format($totalDepense, 2, ',', ' ') ?> €
            </h4>
        </div>
    </div>
</div>

<!-- ── Bottom grid : chart + recent transactions ── -->
<div class="dashboard-grid">
    <div class="chart-container">
        <p class="chart-title">Répartition</p>
        <canvas id="myChart"></canvas>
    </div>

    <div class="recent-container">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
            <p class="chart-title" style="margin:0;">Transactions récentes</p>
            <a href="?p=home&export=csv" class="btn-export-csv" id="csvExportBtn" title="Télécharger toutes les transactions au format CSV (compatible Excel)">
                <span class="btn-export-inner">
                    <i class="ri-file-excel-2-line btn-export-icon"></i>
                    <span class="btn-export-label">Exporter CSV</span>
                    <span class="btn-export-badge"><?= count($transactions) ?></span>
                </span>
            </a>
        </div>
        <?php if (empty($transactions)): ?>
            <p class="no-data">Aucune transaction enregistrée.</p>
        <?php else: ?>
            <ul class="recent-list">
                <?php foreach (array_slice(array_reverse($transactions), 0, 6) as $tx): ?>
                <li class="recent-item">
                    <div class="recent-icon <?= $tx->type === 'revenu' ? 'icon-revenu' : 'icon-depense' ?>">
                        <i class="<?= $tx->type === 'revenu' ? 'ri-arrow-up-line' : 'ri-arrow-down-line' ?>"></i>
                    </div>
                    <div class="recent-info">
                        <span class="recent-desc"><?= htmlspecialchars($tx->description ?: 'Sans description') ?></span>
                        <span class="recent-date"><?= date('d/m/Y', strtotime($tx->date)) ?></span>
                    </div>
                    <span class="recent-amount <?= $tx->type === 'revenu' ? 'val-green' : 'val-red' ?>">
                        <?= $tx->type === 'revenu' ? '+' : '-' ?><?= number_format($tx->montant, 2, ',', ' ') ?> €
                    </span>
                    <div class="recent-actions">
                        <button class="btn-action btn-edit-tx"
                                data-bs-toggle="modal"
                                data-bs-target="#editTransactionModal"
                                data-id="<?= $tx->id ?>"
                                data-montant="<?= $tx->montant ?>"
                                data-description="<?= htmlspecialchars($tx->description) ?>"
                                data-type="<?= $tx->type ?>"
                                data-date="<?= $tx->date ?>">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button class="btn-action btn-delete-tx"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteTransactionModal"
                                data-id="<?= $tx->id ?>"
                                data-desc="<?= htmlspecialchars($tx->description) ?>">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<style>
.btn-export-csv {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    margin-top: 16px;
    border-radius: 10px;
    background: linear-gradient(135deg, #1a7a55 0%, #1D9E75 100%);
    color: #fff;
    font-weight: 600;
    font-size: 0.88rem;
    letter-spacing: 0.02em;
    padding: 0;
    box-shadow: 0 2px 10px rgba(29,158,117,0.18);
    transition: box-shadow 0.18s, transform 0.15s, opacity 0.15s;
    overflow: hidden;
    position: relative;
}
.btn-export-csv:hover {
    box-shadow: 0 4px 18px rgba(29,158,117,0.32);
    transform: translateY(-1px);
    color: #fff;
    opacity: 0.95;
}
.btn-export-csv:active {
    transform: translateY(0px) scale(0.98);
    box-shadow: 0 1px 6px rgba(29,158,117,0.2);
}
.btn-export-inner {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px 10px 14px;
}
.btn-export-icon {
    font-size: 1.15rem;
    flex-shrink: 0;
}
.btn-export-badge {
    background: rgba(255,255,255,0.22);
    border-radius: 20px;
    padding: 1px 8px;
    font-size: 0.78rem;
    font-weight: 700;
    line-height: 1.6;
    margin-left: 2px;
}
.btn-export-csv.loading .btn-export-icon::before {
    content: "\eb4e";
    animation: spin 0.7s linear infinite;
    display: inline-block;
}
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<script>
document.getElementById('csvExportBtn').addEventListener('click', function() {
    this.classList.add('loading');
    this.querySelector('.btn-export-label').textContent = 'Préparation…';
    setTimeout(() => {
        this.classList.remove('loading');
        this.querySelector('.btn-export-label').textContent = 'Exporter CSV';
    }, 2500);
});
</script>

<!-- Modal Modifier transaction -->
<div class="modal fade" id="editTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content tx-modal-content">
            <div class="modal-header tx-modal-header">
                <h5 class="modal-title tx-modal-title">Modifier la transaction</h5>
                <button type="button" class="btn-close tx-btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body tx-modal-body">
                <form method="POST" action="index.php?p=home">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="id" id="edit_tx_id">
                    <div class="tx-field">
                        <label>MONTANT</label>
                        <input type="number" step="0.01" name="montant" id="edit_tx_montant" class="tx-input" required>
                    </div>
                    <div class="tx-field">
                        <label>DESCRIPTION</label>
                        <input type="text" name="description" id="edit_tx_description" class="tx-input">
                    </div>
                    <div class="tx-field">
                        <label>TYPE</label>
                        <select name="type" id="edit_tx_type" class="tx-input">
                            <option value="revenu">Revenu</option>
                            <option value="depense">Dépense</option>
                        </select>
                    </div>
                    <div class="tx-field">
                        <label>DATE</label>
                        <input type="date" name="date" id="edit_tx_date" class="tx-input" required>
                    </div>
                    <button type="submit" class="tx-btn-save">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supprimer transaction -->
<div class="modal fade" id="deleteTransactionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content tx-modal-content tx-modal-delete">
            <div class="modal-header tx-modal-header">
                <h5 class="modal-title tx-modal-title-delete">Supprimer la transaction</h5>
                <button type="button" class="btn-close tx-btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body tx-modal-body">
                <p class="tx-delete-msg">Êtes-vous sûr de vouloir supprimer <strong id="delete_tx_desc"></strong> ?</p>
                <p class="tx-delete-warn">Cette action est irréversible.</p>
                <form method="POST" action="index.php?p=home">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" id="delete_tx_id">
                    <div class="tx-btn-row">
                        <button type="button" class="tx-btn-cancel" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="tx-btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const chartLabels = <?= json_encode($label) ?>;
    const chartData   = <?= json_encode($data) ?>;
</script>
<script src="js/home.js"></script>
<?php
$content = ob_get_clean();
require __DIR__ . '/../template/layout.php';
?>
