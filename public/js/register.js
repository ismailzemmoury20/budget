function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const icon  = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'ri-eye-off-line';
    } else {
        input.type = 'password';
        icon.className = 'ri-eye-line';
    }
}

document.getElementById('password').addEventListener('input', function () {
    const val   = this.value;
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    let score   = 0;

    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;

    const levels = [
        { pct: '0%',   color: '',         text: '' },
        { pct: '25%',  color: '#ff4d6d',  text: 'Faible' },
        { pct: '50%',  color: '#f59e0b',  text: 'Moyen' },
        { pct: '75%',  color: '#908aff',  text: 'Bon' },
        { pct: '100%', color: '#00c896',  text: 'Excellent' },
    ];

    const level = levels[score];
    fill.style.width           = level.pct;
    fill.style.backgroundColor = level.color;
    label.textContent          = level.text;
    label.style.color          = level.color;
});
