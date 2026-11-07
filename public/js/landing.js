// Page d'accueil : la phrase calculée, la saisie en une ligne, les interrupteurs, les apparitions.
(function () {
    const money0 = (v) => Math.round(Math.abs(v)).toLocaleString('fr-FR').replace(/\s/g, ' ') + ' €';
    const money2 = (v) => (v < 0 ? '−' : '') + Math.abs(v).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).replace(/\s/g, ' ') + ' €';
    const $ = (id) => document.getElementById(id);

    // 1. « Il vous reste … au 30. »
    const inc = $('inIncome'), spend = $('inSpend'), save = $('inSave');
    const slot = document.querySelector('.slot');
    function hero() {
        const i = +inc.value, s = +spend.value, kept = save.checked ? Math.round(i * 0.10) : 0;
        const left = i - s - kept;
        $('outIncome').textContent = money0(i);
        $('outSpend').textContent = money0(s);
        $('outSave').textContent = money0(kept);
        $('heroVerb').textContent = left < 0 ? 'Il vous manque' : 'Il vous reste';
        $('heroAmount').textContent = money0(left);
        slot.classList.toggle('is-short', left < 0);
        slot.classList.remove('bump'); void slot.offsetWidth; slot.classList.add('bump');
    }
    [inc, spend, save].forEach((el) => el && el.addEventListener('input', hero));
    if (save) save.addEventListener('change', hero);

    // 2. Saisie en une ligne (mêmes règles que la page « Nouvelle transaction »)
    const cats = [
        { nom: 'Salaire', type: 'revenu', tint: 'tint-0', words: ['salaire'] },
        { nom: 'Freelance', type: 'revenu', tint: 'tint-1', words: ['logo', 'facture', 'freelance', 'mission'] },
        { nom: 'Loyer', type: 'depense', tint: 'tint-2', words: ['loyer'] },
        { nom: 'Courses', type: 'depense', tint: 'tint-3', words: ['courses', 'marché', 'carrefour', 'monoprix', 'franprix', 'boulangerie'] },
        { nom: 'Transport', type: 'depense', tint: 'tint-4', words: ['navigo', 'métro', 'train', 'sncf', 'uber', 'essence', 'vélib'] },
        { nom: 'Restaurants', type: 'depense', tint: 'tint-5', words: ['dîner', 'diner', 'déjeuner', 'restaurant', 'café', 'resto'] },
        { nom: 'Abonnements', type: 'depense', tint: 'tint-0', words: ['spotify', 'netflix', 'abonnement', 'forfait'] },
        { nom: 'Santé', type: 'depense', tint: 'tint-1', words: ['pharmacie', 'médecin', 'dentiste', 'mutuelle'] },
    ];
    const LEFT_BEFORE = 1756.99; // reste du mois d'exemple avant cette ligne
    const line = $('typeLine');
    function parse() {
        const s = line.value.trim();
        const m = s.match(/([+-]?)\s*(\d+(?:[.,]\d{1,2})?)\s*€?\s*$/) || s.match(/([+-]?)\s*(\d+(?:[.,]\d{1,2})?)/);
        const amount = m ? parseFloat(m[2].replace(',', '.')) : 0;
        const label = (m ? s.replace(m[0], '') : s).replace(/\s+/g, ' ').trim();
        const low = label.toLowerCase();
        const cat = cats.find((c) => c.words.some((w) => low.includes(w)));
        const income = (m && m[1] === '+') || (cat && cat.type === 'revenu');
        $('ansTitle').textContent = label || 'Sans description';
        $('ansCat').textContent = (cat ? cat.nom : 'Sans catégorie') + " · aujourd'hui";
        const tile = $('ansTile');
        tile.className = 'tile ' + (cat ? cat.tint : 'tint-none');
        tile.textContent = (cat ? cat.nom : label || '–').charAt(0).toUpperCase();
        const a = $('ansAmount');
        a.textContent = (income ? '+' : '') + money2(amount);
        a.classList.toggle('amount-in', !!income);
        $('ansBefore').textContent = money2(LEFT_BEFORE);
        const after = Math.round((LEFT_BEFORE + (income ? amount : -amount)) * 100) / 100;
        $('ansAfter').textContent = money2(after);
        $('ansAfter').classList.toggle('is-negative', after < 0);
        // jauge : dépenses du mois d'exemple (1 012,99 € avant cette ligne) sur les revenus (2 770 €)
        const spent = 1012.99 + (income ? 0 : amount), revenue = 2770 + (income ? amount : 0);
        const pct = Math.min(100, spent / revenue * 100);
        $('ansGauge').style.width = pct.toFixed(1) + '%';
        $('ansSpent').textContent = Math.round(pct) + '\u00a0% des revenus dépensés';
        const today = $('ansToday');
        today.style.setProperty('--v', income ? 0 : Math.min(100, Math.round(amount / 780 * 100)));
    }
    if (line) {
        line.addEventListener('input', parse);
        document.querySelectorAll('[data-example]').forEach((b) => b.addEventListener('click', () => {
            line.value = b.dataset.example; parse(); line.focus();
        }));
        parse();
    }

    // 3. Interrupteurs des bandes
    document.querySelectorAll('.band .toggle').forEach((t) => t.addEventListener('click', () => {
        const on = t.getAttribute('aria-checked') !== 'true';
        t.setAttribute('aria-checked', String(on));
        t.closest('.band').classList.toggle('is-on', on);
    }));

    // 4. Apparitions, une seule fois
    const targets = document.querySelectorAll('[data-reveal], .band');
    if (!('IntersectionObserver' in window)) { targets.forEach((el) => el.classList.add('is-in')); return; }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.1 });
    targets.forEach((el, i) => {
        if (el.classList.contains('band')) el.style.transitionDelay = ((i % 5) * 70) + 'ms';
        io.observe(el);
    });

    // 5. L'extrait du tableau de bord dérive doucement au défilement
    const drift = $('drift');
    if (drift && !matchMedia('(prefers-reduced-motion: reduce)').matches) {
        let ticking = false;
        addEventListener('scroll', () => {
            if (ticking) return; ticking = true;
            requestAnimationFrame(() => {
                const r = drift.parentElement.getBoundingClientRect();
                const p = Math.max(-1, Math.min(1, (r.top + r.height / 2 - innerHeight / 2) / innerHeight));
                drift.style.transform = 'translateY(' + (p * 24).toFixed(1) + 'px)';
                ticking = false;
            });
        }, { passive: true });
    }
})();
