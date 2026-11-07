<?php
/* Page d'accueil publique.
   L'idée : la question de chaque fin de mois (« combien me reste-t-il au 30 ? ») est le titre,
   et le chiffre au milieu de la phrase est calculé en direct par les réglages posés dessus. */
$year = date('Y');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Budget · le carnet de comptes qui calcule votre fin de mois</title>
    <meta name="description" content="Budget est un carnet de comptes en ligne : notez revenus et dépenses, classez-les par catégorie, voyez ce qu'il reste jusqu'au 30 et exportez tout en CSV.">
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect width='24' height='24' rx='7' fill='%231d5fd6'/%3E%3Crect x='6' y='7' width='12' height='2.2' rx='1.1' fill='white'/%3E%3Crect x='6' y='11' width='9' height='2.2' rx='1.1' fill='white'/%3E%3Crect x='6' y='15' width='6' height='2.2' rx='1.1' fill='white'/%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/tokens.css">
    <link rel="stylesheet" href="css/site.css">
    <script>document.documentElement.classList.add('js')</script>
</head>
<body class="site">

<!-- ── Premier écran : la phrase de fin de mois ─────────────────── -->
<header class="hero" id="haut">
    <nav class="topnav" aria-label="Navigation principale">
        <a href="index.php?p=landing" class="wordmark"><?php require __DIR__ . '/../partials/logo.php'; ?>Budget</a>
        <div class="topnav-links">
            <a href="#saisie">Saisie</a>
            <a href="#categories">Catégories</a>
            <a href="#questions">Questions</a>
            <a href="index.php?p=login" class="topnav-login">Se connecter</a>
        </div>
    </nav>

    <div class="hero-stage">
        <h1 class="hero-title lines" aria-live="polite">
            <span class="line"><span data-line style="--i:0" id="heroVerb">Il vous reste</span></span>
            <span class="line"><span data-line style="--i:1"><span class="slot" data-ui><span class="num" id="heroAmount">1&#8239;070&nbsp;€</span></span> au 30.</span></span>
        </h1>

        <div class="chips" data-ui>
            <label class="chip chip-a">
                <span class="chip-top"><span>Revenus du mois</span><output class="num" id="outIncome" for="inIncome">2&#8239;350&nbsp;€</output></span>
                <input type="range" id="inIncome" min="0" max="5000" step="50" value="2350" aria-label="Revenus du mois, en euros">
            </label>
            <label class="chip chip-b">
                <span class="chip-top"><span>Dépenses du mois</span><output class="num" id="outSpend" for="inSpend">1&#8239;280&nbsp;€</output></span>
                <input type="range" id="inSpend" min="0" max="5000" step="10" value="1280" aria-label="Dépenses du mois, en euros">
            </label>
            <label class="chip chip-c">
                <span class="chip-top"><span>Mettre 10&nbsp;% de côté</span><output class="num" id="outSave" for="inSave">0&nbsp;€</output></span>
                <span class="switch"><input type="checkbox" id="inSave" role="switch"><span class="switch-track" aria-hidden="true"></span></span>
            </label>
        </div>

        <div class="hero-foot" data-load style="--d:520ms">
            <p class="hero-lead">Budget est un carnet de comptes en ligne&nbsp;: vous notez revenus et dépenses, il calcule ce qu'il reste jusqu'à la fin du mois.</p>
            <div class="hero-actions">
                <a href="index.php?p=register" class="btn btn-light btn-lg">Créer mon carnet</a>
                <a href="index.php?p=login" class="text-link">J'ai déjà un compte</a>
            </div>
        </div>
    </div>
</header>

<main>
<!-- ── Saisie en une ligne ─────────────────────────────────────── -->
<section class="showcase" id="saisie" aria-labelledby="saisie-title">
    <div class="wrap">
        <h2 id="saisie-title" class="statement" data-reveal>Une dépense, une ligne.</h2>
        <label for="typeLine" class="sr-only">Écrivez une opération, par exemple « Courses 52,17 »</label>
        <div class="typeline" data-ui data-reveal style="--d:80ms">
            <input id="typeLine" type="text" value="Marché d'Aligre 52,17" autocomplete="off" spellcheck="false">
        </div>
        <div class="showcase-proof">
            <div class="answer" data-ui data-reveal style="--d:160ms" aria-live="polite">
                <p class="answer-head">Dernières opérations</p>
                <div class="answer-row is-new">
                    <span class="tile tint-3" id="ansTile" aria-hidden="true">C</span>
                    <span class="answer-main"><span class="answer-title" id="ansTitle">Marché d'Aligre</span><span class="answer-sub" id="ansCat">Courses · aujourd'hui</span></span>
                    <span class="answer-amount num" id="ansAmount">52,17&nbsp;€</span>
                </div>
                <div class="answer-row">
                    <span class="tile tint-1" aria-hidden="true">S</span>
                    <span class="answer-main"><span class="answer-title">Pharmacie</span><span class="answer-sub">Santé · hier</span></span>
                    <span class="answer-amount num">27,80&nbsp;€</span>
                </div>
                <div class="answer-row">
                    <span class="tile tint-5" aria-hidden="true">R</span>
                    <span class="answer-main"><span class="answer-title">Dîner rue Oberkampf</span><span class="answer-sub">Restaurants · 5 nov.</span></span>
                    <span class="answer-amount num">38,50&nbsp;€</span>
                </div>
            </div>
            <div class="month-frag" data-ui data-reveal style="--d:240ms" aria-live="polite">
                <p class="answer-head">Reste en novembre</p>
                <p class="month-frag-lead num" id="ansAfter">1&#8239;704,82&nbsp;€</p>
                <p class="answer-sub">avant cette ligne&nbsp;: <span class="num" id="ansBefore">1&#8239;756,99&nbsp;€</span></p>
                <div class="frag-gauge"><span id="ansGauge" style="width:38.5%"></span></div>
                <div class="frag-legend"><span id="ansSpent">38&nbsp;% des revenus dépensés</span><span class="num">sur 2&#8239;770,00&nbsp;€</span></div>
                <div class="frag-days" aria-hidden="true">
                    <span style="--v:100"></span><span style="--v:20"></span><span style="--v:2"></span><span style="--v:0"></span><span style="--v:5"></span><span style="--v:5"></span><span style="--v:4" class="today" id="ansToday"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span><span class="future"></span>
                </div>
            </div>
        </div>
        <div class="examples" data-reveal style="--d:240ms">
            <span class="examples-label">Essayez&nbsp;:</span>
            <button type="button" data-example="Salaire novembre +2350">Salaire novembre +2350</button>
            <button type="button" data-example="Navigo 86,40">Navigo 86,40</button>
            <button type="button" data-example="Dîner rue Oberkampf 38,50">Dîner rue Oberkampf 38,50</button>
        </div>
    </div>
</section>

<!-- ── Ce que fait le carnet, interrupteur par interrupteur ────── -->
<section class="switches" aria-labelledby="switches-title">
    <div class="wrap">
        <h2 id="switches-title" class="statement" data-reveal>Ce que le carnet fait pour vous.</h2>
    </div>
    <ul class="bands">
        <li class="band tint-0 is-on">
            <div class="wrap band-inner">
                <div class="band-text"><p class="band-sentence">Classer chaque dépense dans sa catégorie</p><p class="band-result num">Loyer 780,00&nbsp;€ · Courses 116,49&nbsp;€ · Transport 86,40&nbsp;€ en novembre</p></div>
                <button type="button" class="toggle" role="switch" aria-checked="true" aria-label="Classer chaque dépense dans sa catégorie"><span></span></button>
            </div>
        </li>
        <li class="band tint-1 is-on">
            <div class="wrap band-inner">
                <div class="band-text"><p class="band-sentence">Savoir ce qu'il reste par jour jusqu'au 30</p><p class="band-result num">1&#8239;704,82&nbsp;€ pour 24&nbsp;jours, soit 71,03&nbsp;€ par jour</p></div>
                <button type="button" class="toggle" role="switch" aria-checked="true" aria-label="Savoir ce qu'il reste par jour jusqu'au 30"><span></span></button>
            </div>
        </li>
        <li class="band tint-2">
            <div class="wrap band-inner">
                <div class="band-text"><p class="band-sentence">Repérer la plus grosse dépense du mois</p><p class="band-result num">Loyer&nbsp;: 73&nbsp;% des 1&#8239;065,18&nbsp;€ dépensés en novembre</p></div>
                <button type="button" class="toggle" role="switch" aria-checked="false" aria-label="Repérer la plus grosse dépense du mois"><span></span></button>
            </div>
        </li>
        <li class="band tint-3">
            <div class="wrap band-inner">
                <div class="band-text"><p class="band-sentence">Emporter tout le carnet dans un tableur</p><p class="band-result">Un fichier CSV daté du jour, qui s'ouvre dans Excel, Numbers ou LibreOffice</p></div>
                <button type="button" class="toggle" role="switch" aria-checked="false" aria-label="Emporter tout le carnet dans un tableur"><span></span></button>
            </div>
        </li>
        <li class="band tint-4">
            <div class="wrap band-inner">
                <div class="band-text"><p class="band-sentence">Garder une note sous chaque opération</p><p class="band-result">«&nbsp;Facture n°&nbsp;2026-014&nbsp;» sous le logo dessiné pour l'Atelier Brun</p></div>
                <button type="button" class="toggle" role="switch" aria-checked="false" aria-label="Garder une note sous chaque opération"><span></span></button>
            </div>
        </li>
    </ul>
</section>

<!-- ── Les catégories ──────────────────────────────────────────── -->
<section class="cats" id="categories" aria-labelledby="cats-title">
    <div class="wrap">
        <h2 id="cats-title" class="cats-title" data-reveal>Vos catégories,<br>vos couleurs</h2>
        <div class="cats-body">
            <figure class="cats-picture" data-ui data-reveal aria-label="Extrait du tableau de bord : dépenses de novembre par catégorie">
                <div class="mini-card" id="drift">
                    <p class="mini-title">Dépenses par catégorie</p>
                    <ul class="mini-rows">
                        <li><span class="tile tint-2">L</span><span class="mini-name">Loyer<span class="mini-bar" style="width:100%"></span></span><span class="num">780,00&nbsp;€</span></li>
                        <li><span class="tile tint-3">C</span><span class="mini-name">Courses<span class="mini-bar" style="width:15%"></span></span><span class="num">116,49&nbsp;€</span></li>
                        <li><span class="tile tint-4">T</span><span class="mini-name">Transport<span class="mini-bar" style="width:11%"></span></span><span class="num">86,40&nbsp;€</span></li>
                        <li><span class="tile tint-5">R</span><span class="mini-name">Restaurants<span class="mini-bar" style="width:5%"></span></span><span class="num">38,50&nbsp;€</span></li>
                        <li><span class="tile tint-1">S</span><span class="mini-name">Santé<span class="mini-bar" style="width:4%"></span></span><span class="num">27,80&nbsp;€</span></li>
                    </ul>
                </div>
                <figcaption>Chaque catégorie garde sa teinte, de la saisie au tableau de bord.</figcaption>
            </figure>
            <div class="cats-table" data-reveal style="--d:100ms">
                <p class="cats-word">Exemples</p>
                <table>
                    <caption class="sr-only">Exemples de catégories et d'opérations</caption>
                    <thead class="sr-only"><tr><th scope="col">Type</th><th scope="col">Catégorie</th><th scope="col">Opération type</th><th scope="col">Montant</th></tr></thead>
                    <tbody>
                        <tr><td class="kind">Revenu</td><td><span class="dot tint-0"></span>Salaire</td><td class="soft">le 1<sup>er</sup> du mois</td><td class="num amount-in">+2&#8239;350,00&nbsp;€</td></tr>
                        <tr><td class="kind">Revenu</td><td><span class="dot tint-1"></span>Freelance</td><td class="soft">logo, Atelier Brun</td><td class="num amount-in">+420,00&nbsp;€</td></tr>
                        <tr><td class="kind">Dépense</td><td><span class="dot tint-2"></span>Loyer</td><td class="soft">virement du 1<sup>er</sup></td><td class="num">780,00&nbsp;€</td></tr>
                        <tr><td class="kind">Dépense</td><td><span class="dot tint-3"></span>Courses</td><td class="soft">marché d'Aligre</td><td class="num">52,17&nbsp;€</td></tr>
                        <tr class="gap"><td class="kind">Dépense</td><td><span class="dot tint-4"></span>Transport</td><td class="soft">Navigo mensuel</td><td class="num">86,40&nbsp;€</td></tr>
                        <tr><td class="kind">Dépense</td><td><span class="dot tint-5"></span>Restaurants</td><td class="soft">dîner rue Oberkampf</td><td class="num">38,50&nbsp;€</td></tr>
                        <tr><td class="kind">Dépense</td><td><span class="dot tint-0"></span>Abonnements</td><td class="soft">musique et films</td><td class="num">15,99&nbsp;€</td></tr>
                        <tr><td class="kind">Dépense</td><td><span class="dot tint-1"></span>Santé</td><td class="soft">pharmacie</td><td class="num">27,80&nbsp;€</td></tr>
                    </tbody>
                </table>
                <p class="cats-note">Créez, renommez ou supprimez les vôtres&nbsp;; rien n'est imposé.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── Questions ───────────────────────────────────────────────── -->
<section class="faq" id="questions" aria-labelledby="faq-title">
    <div class="wrap">
        <h2 id="faq-title" class="faq-title" data-reveal>Avant de commencer</h2>
        <div class="faq-list" data-reveal style="--d:100ms">
            <details>
                <summary>Faut-il relier mon compte bancaire&nbsp;?</summary>
                <p>Non. Vous notez vous-même chaque opération&nbsp;: Budget n'a accès à aucune banque et ne lit aucun relevé.</p>
            </details>
            <details>
                <summary>Combien coûte Budget&nbsp;?</summary>
                <p>Rien. Créer un carnet, y noter vos opérations et les exporter est gratuit.</p>
            </details>
            <details>
                <summary>Où sont gardées mes données&nbsp;?</summary>
                <p>Dans la base de données du site, liées à votre compte. Votre mot de passe n'est jamais enregistré en clair&nbsp;: seule son empreinte chiffrée est conservée.</p>
            </details>
            <details>
                <summary>Puis-je récupérer tout mon carnet&nbsp;?</summary>
                <p>Oui, à tout moment, en un clic&nbsp;: un fichier CSV avec le montant, la description, le type, la catégorie, la date et les notes de chaque opération.</p>
            </details>
            <details>
                <summary>Est-ce que ça marche sur téléphone&nbsp;?</summary>
                <p>Oui. Le tableau de bord, la saisie et les catégories s'adaptent à l'écran&nbsp;; le bouton «&nbsp;+&nbsp;» reste en haut pour noter une dépense à la caisse.</p>
            </details>
            <details>
                <summary>Et si je supprime une catégorie&nbsp;?</summary>
                <p>Ses opérations restent dans le carnet, classées «&nbsp;Sans catégorie&nbsp;», et le solde ne change pas.</p>
            </details>
        </div>
    </div>
</section>

<!-- ── Le choix final ──────────────────────────────────────────── -->
<section class="choice" aria-labelledby="choice-title">
    <h2 id="choice-title" class="choice-title">
        <span class="choice-l1" data-reveal>On ouvre</span>
        <span class="choice-l2" data-reveal style="--d:120ms">un carnet&nbsp;?</span>
    </h2>
    <div class="choice-row" data-reveal style="--d:200ms">
        <div class="choice-buttons">
            <a href="index.php?p=register" class="btn btn-light btn-xl">Créer mon carnet</a>
            <span class="choice-or">ou</span>
            <a href="index.php?p=login" class="btn btn-outline-light btn-xl">J'en ai déjà un</a>
        </div>
        <p class="choice-note">Un nom, un e-mail, un mot de passe&nbsp;: le carnet est prêt.</p>
    </div>
</section>
</main>

<footer class="foot">
    <div class="wrap foot-top">
        <div>
            <p class="foot-invite">Votre mois,<br>ligne par ligne.</p>
            <a href="index.php?p=register" class="btn btn-primary btn-lg">Créer mon carnet</a>
        </div>
        <ul class="foot-links">
            <li><a href="#saisie">Saisie</a></li>
            <li><a href="#categories">Catégories</a></li>
            <li><a href="#questions">Questions</a></li>
            <li><a href="index.php?p=login">Se connecter</a></li>
        </ul>
    </div>
    <div class="wrap foot-legal">
        <span>Budget &copy; <?= $year ?></span>
        <span>Carnet de comptes personnel</span>
    </div>
    <p class="foot-name" aria-hidden="true">Budget</p>
</footer>

<script src="js/landing.js"></script>
</body>
</html>
