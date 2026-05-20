const html       = document.documentElement;
const icon       = document.getElementById('themeIcon');
const savedTheme = localStorage.getItem('budget-theme') || 'dark';

function applyTheme(theme) {
    html.setAttribute('data-theme', theme);
    icon.className = theme === 'dark' ? 'ri-sun-line' : 'ri-moon-line';
    localStorage.setItem('budget-theme', theme);
}

applyTheme(savedTheme);

document.getElementById('themeToggle').addEventListener('click', () => {
    applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
});

document.getElementById('navToggle').addEventListener('click', () => {
    document.getElementById('navLinks').classList.toggle('open');
});

document.querySelectorAll('#navLinks a').forEach(a => {
    a.addEventListener('click', () => {
        document.getElementById('navLinks').classList.remove('open');
    });
});
