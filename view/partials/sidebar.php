<aside class="sidebar">
    <a href="index.php" class="sidebar-logo" style="text-decoration: none; color: inherit;">
        <div class="logo-icon">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="22" height="22" rx="7" fill="url(#logoGrad)"/>
                <path d="M6 7h5.5a2.5 2.5 0 0 1 0 5H6V7Z" fill="white" fill-opacity="0.95"/>
                <path d="M6 12h6a2.5 2.5 0 0 1 0 5H6v-5Z" fill="white" fill-opacity="0.7"/>
                <defs>
                    <linearGradient id="logoGrad" x1="0" y1="0" x2="22" y2="22" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="#908aff"/>
                        <stop offset="100%" stop-color="#6c63ff"/>
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <span class="logo-text">Budget</span>
    </a>
    <nav class="sidebar-nav">
        <a href="index.php">
            <i class="ri-dashboard-line"></i> Tableau de bord
        </a>
        <a href="index.php?p=add">
            <i class="ri-add-circle-line"></i> Ajouter une transaction
        </a>
        <a href="index.php?p=categorie">
            <i class="ri-pie-chart-line"></i> Catégories
        </a>
        <a href="index.php?p=deconnexion">
            <i class="ri-logout-circle-r-line"></i> Déconnexion
        </a>
    </nav>
    <div class="sidebar-footer">
        Budget Personnel &copy; <?= date('Y') ?>
    </div>
</aside>