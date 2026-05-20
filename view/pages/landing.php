<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget — Gérez vos finances simplement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css/landing.css">
</head>
<body>

    <nav>
        <a href="index.php" class="nav-logo">
            <i class="ri-line-chart-fill"></i> BUDGET
        </a>
        <ul class="nav-links" id="navLinks">
            <li><a href="#features">Fonctionnalités</a></li>
            <li><a href="#how">Comment ça marche</a></li>
            <li><a href="#categories">Catégories</a></li>
        </ul>
        <div class="nav-right">
            <button class="theme-toggle" id="themeToggle" aria-label="Changer le thème">
                <i class="ri-moon-line" id="themeIcon"></i>
            </button>
            <a href="index.php?p=login" class="nav-cta">Se connecter</a>
            <button class="nav-hamburger" id="navToggle" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-badge">
            <i class="ri-sparkling-2-line"></i> Gestion financière personnelle
        </div>
        <h1>Prenez le contrôle de<br><span>vos finances</span></h1>
        <p>Suivez vos revenus, maîtrisez vos dépenses et visualisez votre patrimoine — tout en un seul endroit, propre et intuitif.</p>
        <div class="hero-actions">
            <a href="index.php?p=login" class="btn-primary">
                <i class="ri-rocket-line"></i> Commencer maintenant
            </a>
            <a href="#features" class="btn-outline">
                <i class="ri-play-circle-line"></i> Voir les fonctionnalités
            </a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-value">100%</span>
                <span class="stat-label">Gratuit</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-value">∞</span>
                <span class="stat-label">Transactions</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-item">
                <span class="stat-value">🔒</span>
                <span class="stat-label">Données privées</span>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="section-inner">
            <div class="features-header">
                <p class="section-label">Fonctionnalités</p>
                <h2 class="section-title">Tout ce dont vous avez besoin</h2>
                <p class="section-sub">Un outil simple et puissant pour garder un œil sur chaque euro.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="ri-add-circle-line"></i></div>
                    <h3 class="feature-title">Ajout rapide de transactions</h3>
                    <p class="feature-desc">Enregistrez un revenu ou une dépense en quelques secondes avec description, catégorie et date.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="ri-pie-chart-2-line"></i></div>
                    <h3 class="feature-title">Catégories personnalisables</h3>
                    <p class="feature-desc">Créez, modifiez et supprimez vos catégories pour organiser votre budget selon vos habitudes.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="ri-bar-chart-box-line"></i></div>
                    <h3 class="feature-title">Tableau de bord visuel</h3>
                    <p class="feature-desc">Visualisez votre solde, vos revenus totaux et vos dépenses sur un tableau de bord clair.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="ri-shield-check-line"></i></div>
                    <h3 class="feature-title">Accès sécurisé</h3>
                    <p class="feature-desc">Vos données restent privées grâce à un système d'authentification par identifiant et mot de passe.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="ri-search-2-line"></i></div>
                    <h3 class="feature-title">Suivi par type</h3>
                    <p class="feature-desc">Distinguez facilement revenus et dépenses grâce à un système de badges visuels colorés.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="ri-device-line"></i></div>
                    <h3 class="feature-title">Design responsive</h3>
                    <p class="feature-desc">Consultez votre budget depuis n'importe quel appareil — ordinateur, tablette ou smartphone.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="how" id="how">
        <div class="section-inner how-inner">
            <div>
                <p class="section-label">Comment ça marche</p>
                <h2 class="section-title">Opérationnel en 3 étapes</h2>
                <p class="section-sub">Pas de complexité inutile. Commencez à suivre vos finances en moins d'une minute.</p>
                <div class="how-steps">
                    <div class="step">
                        <div class="step-num">1</div>
                        <div class="step-content">
                            <h4>Créez votre compte</h4>
                            <p>Inscrivez-vous avec un identifiant et un mot de passe. Vos données vous appartiennent.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-num">2</div>
                        <div class="step-content">
                            <h4>Configurez vos catégories</h4>
                            <p>Ajoutez vos catégories de revenus et de dépenses selon votre style de vie.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-num">3</div>
                        <div class="step-content">
                            <h4>Enregistrez vos transactions</h4>
                            <p>Ajoutez chaque mouvement financier et consultez votre tableau de bord en temps réel.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-preview">
                <div class="preview-topbar">
                    <div class="preview-dot"></div>
                    <div class="preview-dot"></div>
                    <div class="preview-dot"></div>
                </div>
                <div class="preview-body">
                    <div class="preview-cards">
                        <div class="preview-card">
                            <div class="preview-card-label">Solde</div>
                            <div class="preview-card-val">3 240 €</div>
                        </div>
                        <div class="preview-card">
                            <div class="preview-card-label">Revenus</div>
                            <div class="preview-card-val green">+4 800 €</div>
                        </div>
                        <div class="preview-card">
                            <div class="preview-card-label">Dépenses</div>
                            <div class="preview-card-val red">−1 560 €</div>
                        </div>
                    </div>
                    <div class="preview-bar">
                        <div class="preview-bar-label">Répartition par catégorie</div>
                        <div class="preview-bars">
                            <div class="bar-row">
                                <span class="bar-name">Alimentation</span>
                                <div class="bar-track"><div class="bar-fill red" style="width:72%"></div></div>
                                <span class="bar-pct">72%</span>
                            </div>
                            <div class="bar-row">
                                <span class="bar-name">Transport</span>
                                <div class="bar-track"><div class="bar-fill" style="width:45%"></div></div>
                                <span class="bar-pct">45%</span>
                            </div>
                            <div class="bar-row">
                                <span class="bar-name">Salaire</span>
                                <div class="bar-track"><div class="bar-fill green" style="width:88%"></div></div>
                                <span class="bar-pct">88%</span>
                            </div>
                            <div class="bar-row">
                                <span class="bar-name">Freelance</span>
                                <div class="bar-track"><div class="bar-fill green" style="width:32%"></div></div>
                                <span class="bar-pct">32%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="categories-section" id="categories">
        <div class="section-inner">
            <p class="section-label">Organisation</p>
            <h2 class="section-title">Vos catégories, votre façon</h2>
            <p class="section-sub">Créez autant de catégories que vous le souhaitez, en revenus ou en dépenses.</p>
            <div class="cat-grid">
                <div class="cat-pill">
                    <div class="cat-pill-icon green"><i class="ri-briefcase-line"></i></div>
                    <div class="cat-pill-info"><h4>Salaire</h4><p>Revenu mensuel</p></div>
                    <span class="cat-pill-amount" style="color:var(--green)">+2 400 €</span>
                </div>
                <div class="cat-pill">
                    <div class="cat-pill-icon red"><i class="ri-shopping-cart-line"></i></div>
                    <div class="cat-pill-info"><h4>Courses</h4><p>Dépense mensuelle</p></div>
                    <span class="cat-pill-amount" style="color:var(--red)">−320 €</span>
                </div>
                <div class="cat-pill">
                    <div class="cat-pill-icon purple"><i class="ri-code-s-slash-line"></i></div>
                    <div class="cat-pill-info"><h4>Freelance</h4><p>Revenu variable</p></div>
                    <span class="cat-pill-amount" style="color:var(--green)">+800 €</span>
                </div>
                <div class="cat-pill">
                    <div class="cat-pill-icon orange"><i class="ri-car-line"></i></div>
                    <div class="cat-pill-info"><h4>Transport</h4><p>Dépense mensuelle</p></div>
                    <span class="cat-pill-amount" style="color:var(--red)">−95 €</span>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="section-inner">
            <div class="cta-box">
                <h2>Prêt à maîtriser votre budget ?</h2>
                <p>Rejoignez l'application et commencez à suivre vos finances dès aujourd'hui. C'est gratuit.</p>
                <a href="index.php?p=login" class="btn-primary">
                    <i class="ri-rocket-line"></i> Se connecter
                </a>
            </div>
        </div>
    </section>

    <footer>
        <span class="footer-logo">BUDGET</span>
        <span class="footer-copy">Budget Personnel &copy; <?= date('Y') ?> — Tous droits réservés</span>
        <ul class="footer-links">
            <li><a href="#features">Fonctionnalités</a></li>
            <li><a href="#how">Comment ça marche</a></li>
            <li><a href="index.php?p=login">Se connecter</a></li>
        </ul>
    </footer>

    <script src="js/landing.js"></script>
</body>
</html>
