<?php require __DIR__ . '/../partials/header.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>
<?php
/** @var float $content */
?>
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="main-wrapper">
    <header class="topbar">
        <div class="topbar-left">
            <button class="hamburger" id="sidebarToggle" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
            <div class="topbar-title">
                <i class="<?= $pageIcon ?? 'ri-dashboard-line' ?>"></i>
                <span><?= $pageTitle ?? 'Tableau de bord' ?></span>
            </div>
        </div>
        <a href="index.php?p=add" class="btn-primary-custom">
            <i class="ri-add-circle-line"></i>
            <span class="btn-label">Ajouter une transaction</span>
        </a>
    </header>
    <main class="page-content">
        <?= $content ?>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');
    const sidebar = document.querySelector('.sidebar');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('visible');
        document.body.style.overflow = '';
    }

    toggle.addEventListener('click', () => {
        sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
    });
    overlay.addEventListener('click', closeSidebar);
</script>
</body>
</html>
