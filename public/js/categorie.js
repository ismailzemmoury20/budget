// Modifier
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('edit_id').value  = btn.dataset.id;
        document.getElementById('edit_nom').value = btn.dataset.nom;
        document.getElementById('edit_type').value = btn.dataset.type;
    });
});

// Supprimer
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('delete_id').value  = btn.dataset.id;
        document.getElementById('delete_nom').textContent = btn.dataset.nom;
    });
});