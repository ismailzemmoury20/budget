// Nouvelle transaction : saisie rapide, catégories filtrées par type et aperçu en direct
(function () {
    const B = window.BUDGET;
    const $ = (id) => document.getElementById(id);
    const form = $('txForm');
    const quick = $('quick'), amount = $('montant'), desc = $('description'), cat = $('categorie_id'), date = $('date');
    const money = (v) => (v < 0 ? '−' : '') + Math.abs(v).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
    const type = () => form.querySelector('input[name=type]:checked').value;
    const parseAmount = (s) => parseFloat(String(s).replace(/\s/g, '').replace(',', '.')) || 0;

    function filterCats() {
        const t = type();
        [...cat.options].forEach((o) => {
            if (!o.value) return;
            o.hidden = o.dataset.type !== t;
        });
        if (cat.selectedOptions[0] && cat.selectedOptions[0].hidden) cat.value = '';
    }

    function shortDate(iso) {
        if (!iso) return '—';
        const d = new Date(iso + 'T12:00:00'), t = new Date();
        const same = (a, b) => a.toDateString() === b.toDateString();
        if (same(d, t)) return "Aujourd'hui";
        const y = new Date(t); y.setDate(t.getDate() - 1);
        if (same(d, y)) return 'Hier';
        return d.toLocaleDateString('fr-FR', { day: 'numeric', month: 'short' });
    }

    function render() {
        const t = type(), a = parseAmount(amount.value);
        const c = B.cats.find((x) => String(x.id) === cat.value);
        $('pvTitle').textContent = desc.value.trim() || 'Sans description';
        $('pvCat').textContent = c ? c.nom : 'Sans catégorie';
        const tile = $('pvTile');
        tile.className = 'tile ' + (c ? c.tint : 'tint-none');
        tile.textContent = (c ? c.nom : desc.value.trim() || '–').charAt(0).toUpperCase();
        const pa = $('pvAmount');
        pa.textContent = t === 'revenu' ? '+' + money(a) : money(a);
        pa.classList.toggle('amount-in', t === 'revenu');
        $('pvDate').textContent = shortDate(date.value);

        const d = date.value ? new Date(date.value + 'T12:00:00') : null;
        const inMonth = d && d.getMonth() + 1 === B.month && d.getFullYear() === B.year;
        const delta = inMonth ? (t === 'revenu' ? a : -a) : 0;
        $('pvDelta').textContent = a ? (inMonth ? (delta >= 0 ? '+' : '−') + money(Math.abs(delta)) : 'hors ' + B.monthLabel) : '—';
        const after = Math.round((B.left + delta) * 100) / 100;
        const pvAfter = $('pvAfter');
        pvAfter.textContent = money(after);
        pvAfter.classList.toggle('is-negative', after < 0);
        $('pvNote').textContent = after < 0 && inMonth ? 'Le mois passerait dans le rouge de ' + money(-after) + '.' : '';
    }

    // « Courses 52,17 », « +420 logo Atelier Brun », « salaire 2350 »
    quick.addEventListener('input', () => {
        const s = quick.value.trim();
        const m = s.match(/([+-]?)\s*(\d+(?:[.,]\d{1,2})?)\s*€?/);
        if (m) amount.value = m[2].replace('.', ',');
        const label = s.replace(m ? m[0] : '', '').replace(/\s+/g, ' ').trim();
        desc.value = label;
        const lower = label.toLowerCase();
        // nom de la catégorie dans le libellé, sinon quelques mots courants
        const HINTS = {
            salaire: ['salaire'], freelance: ['facture', 'mission', 'logo'], loyer: ['loyer'],
            courses: ['courses', 'marché', 'carrefour', 'monoprix', 'franprix', 'lidl', 'boulangerie'],
            transport: ['navigo', 'métro', 'train', 'sncf', 'uber', 'essence', 'vélib'],
            restaurants: ['dîner', 'diner', 'déjeuner', 'restaurant', 'resto', 'café'],
            abonnements: ['spotify', 'netflix', 'abonnement', 'forfait'],
            'santé': ['pharmacie', 'médecin', 'dentiste', 'mutuelle'],
        };
        const found = B.cats.find((c) => lower.includes(c.nom.toLowerCase()))
            || B.cats.find((c) => (HINTS[c.nom.toLowerCase()] || []).some((w) => lower.includes(w)));
        const isIncome = (m && m[1] === '+') || (found && found.type === 'revenu') || /salaire|virement reçu|remboursement/.test(lower);
        form.querySelector('#type-' + (isIncome ? 'revenu' : 'depense')).checked = true;
        filterCats();
        if (found && found.type === type()) cat.value = String(found.id);
        render();
    });

    form.querySelectorAll('input[name=type]').forEach((r) => r.addEventListener('change', () => { filterCats(); render(); }));
    [amount, desc, cat, date].forEach((el) => el.addEventListener('input', render));
    form.addEventListener('submit', (e) => {
        if (parseAmount(amount.value) <= 0) { e.preventDefault(); amount.focus(); amount.setCustomValidity('Indiquez un montant supérieur à 0 €.'); amount.reportValidity(); }
        else amount.setCustomValidity('');
    });
    filterCats();
    render();
})();
