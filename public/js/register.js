// Afficher / masquer le mot de passe
document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.togglePassword);
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
        btn.querySelector('use').setAttribute('href', show ? '#i-eye-off' : '#i-eye');
    });
});

// Solidité du mot de passe (page d'inscription)
(function () {
    const input = document.getElementById('password');
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strength-text');
    if (!input || !fill) return;
    const hint = text.textContent;
    const levels = [
        { w: '0%', c: '', t: hint },
        { w: '25%', c: '#c41c29', t: 'Faible : ajoutez des caractères, une majuscule, un chiffre ou un symbole.' },
        { w: '50%', c: '#92400e', t: 'Moyen : encore un critère pour le renforcer.' },
        { w: '75%', c: '#1d5fd6', t: 'Bon.' },
        { w: '100%', c: '#2f7a45', t: 'Solide.' },
    ];
    input.addEventListener('input', () => {
        const v = input.value;
        let score = 0;
        if (v.length >= 8) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;
        const l = v ? levels[Math.max(1, score)] : levels[0];
        fill.style.width = l.w;
        fill.style.backgroundColor = l.c;
        text.textContent = l.t;
    });
})();
