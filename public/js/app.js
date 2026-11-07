// Menu du téléphone : la barre latérale devient une feuille plein écran
(function () {
    const toggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    if (!toggle || !sidebar) return;
    function set(open) {
        sidebar.classList.toggle('is-open', open);
        document.body.classList.toggle('menu-open', open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
        toggle.querySelector('use').setAttribute('href', open ? '#i-close' : '#i-menu');
    }
    toggle.addEventListener('click', () => set(!sidebar.classList.contains('is-open')));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') set(false); });
})();

// Fenêtres de dialogue natives : <button data-open="idDuDialog" data-*>
document.querySelectorAll('[data-open]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const dialog = document.getElementById(btn.dataset.open);
        if (!dialog) return;
        Object.entries(btn.dataset).forEach(([key, value]) => {
            if (key === 'open') return;
            const field = dialog.querySelector('[data-fill="' + key + '"]');
            if (!field) return;
            if ('value' in field && field.tagName !== 'STRONG' && field.tagName !== 'SPAN') field.value = value;
            else field.textContent = value;
        });
        dialog.showModal();
        const first = dialog.querySelector('input:not([type=hidden]), select, button[type=submit]');
        if (first) first.focus();
    });
});
document.querySelectorAll('dialog').forEach((dialog) => {
    dialog.addEventListener('click', (e) => { if (e.target === dialog) dialog.close(); });
    dialog.querySelectorAll('[data-close]').forEach((b) => b.addEventListener('click', () => dialog.close()));
});
