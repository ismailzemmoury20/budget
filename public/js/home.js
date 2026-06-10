window.onload = function () {
    const ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: [
                    'rgba(0, 200, 150, 0.85)',
                    'rgba(255, 77, 109, 0.85)',
                ],
                borderColor: [
                    'rgba(0, 200, 150, 1)',
                    'rgba(255, 77, 109, 1)',
                ],
                borderWidth: 2,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#6b7280',
                        font: { family: 'Inter', size: 13 },
                        padding: 20,
                        boxWidth: 12,
                        boxHeight: 12,
                    }
                },
                tooltip: {
                    backgroundColor: '#1a1d27',
                    borderColor: '#2a2d3e',
                    borderWidth: 1,
                    titleColor: '#e8eaf0',
                    bodyColor: '#6b7280',
                    padding: 12,
                    callbacks: {
                        label: function (ctx) {
                            return '  ' + ctx.parsed.toFixed(2).replace('.', ',') + ' €';
                        }
                    }
                }
            }
        }
    });
};
// Pré-remplir modal edit
document.querySelectorAll('.btn-edit-tx').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('edit_tx_id').value          = btn.dataset.id;
        document.getElementById('edit_tx_montant').value     = btn.dataset.montant;
        document.getElementById('edit_tx_description').value = btn.dataset.description;
        document.getElementById('edit_tx_type').value        = btn.dataset.type;
        document.getElementById('edit_tx_date').value        = btn.dataset.date;
    });
});

// Pré-remplir modal delete
document.querySelectorAll('.btn-delete-tx').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('delete_tx_id').value       = btn.dataset.id;
        document.getElementById('delete_tx_desc').textContent = btn.dataset.desc;
    });
});
// ── Modals transactions ──
document.addEventListener('DOMContentLoaded', function () {

    // Modifier
    document.querySelectorAll('.btn-edit-tx').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('edit_tx_id').value          = this.dataset.id;
            document.getElementById('edit_tx_montant').value     = this.dataset.montant;
            document.getElementById('edit_tx_description').value = this.dataset.description;
            document.getElementById('edit_tx_date').value        = this.dataset.date;
            const sel = document.getElementById('edit_tx_type');
            sel.value = this.dataset.type;
        });
    });

    // Supprimer
    document.querySelectorAll('.btn-delete-tx').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('delete_tx_id').value   = this.dataset.id;
            document.getElementById('delete_tx_desc').textContent = this.dataset.desc || 'cette transaction';
        });
    });
});
