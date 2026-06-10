# Budget Personnel

Application web de gestion de budget personnel développée en PHP. Elle permet de suivre ses revenus et dépenses, de les classer par catégorie, et d'exporter ses données.

---

## Fonctionnalités

- Inscription / connexion avec session PHP
- Email de bienvenue à l'inscription (SMTP via Gmail)
- Tableau de bord avec solde, total revenus, total dépenses et graphique
- Ajout, modification et suppression de transactions
- Gestion des catégories
- Export CSV des transactions (compatible Excel, encodage UTF-8)

---

## Stack

- PHP 8+ (architecture MVC maison)
- MySQL
- Bootstrap 5
- Chart.js
- PHPMailer
- Composer (autoload PSR-4)

---

## Installation

### Prérequis

- MAMP / WAMP ou équivalent
- PHP 8+
- MySQL
- Composer

### Étapes

1. Cloner le projet dans le dossier `htdocs` :

```bash
git clone https://github.com/ton-repo/budget.git
cd budget
```

2. Installer les dépendances :

```bash
composer install
```

3. Créer la base de données MySQL et importer le schéma (voir ci-dessous).

4. Copier et remplir le fichier de config :

```bash
cp config/settings.example.php config/settings.php
```

```php
return array(
    "db_host" => "localhost",
    "db_name" => "budget",
    "db_user" => "root",
    "db_pass" => "motdepasse"
);
```

5. Configurer le `.env` pour l'envoi d'email :

```
DB_NAME=budget
DB_HOST=localhost
DB_USER=root
DB_PASS=motdepasse
DB_USERNAME=ton@gmail.com
DB_PASSWORD=app_password_gmail
```

> Pour Gmail, générer un mot de passe d'application depuis les paramètres de sécurité Google.

6. Ouvrir `http://localhost:8888/budget/public/index.php` dans le navigateur.

---

## Structure

```
budget/
├── App/
│   ├── Controllers/     # Un contrôleur par page
│   ├── Table/           # Accès base de données (TransactionTable, UserTable…)
│   ├── Mail/            # Templates email (welcome.php)
│   ├── Middleware/      # AuthMiddleware (vérification session)
│   ├── Router.php
│   ├── App.php
│   └── Database.php
├── config/
│   └── settings.php     # Config BDD (ignoré par git)
├── public/
│   ├── index.php        # Point d'entrée
│   ├── css/
│   └── js/
├── view/
│   ├── pages/           # Vues PHP (home, add, categorie…)
│   ├── partials/        # Header et sidebar
│   └── template/        # Layout principal
├── landing.html         # Page d'accueil publique
├── .env                 # Variables d'environnement (ignoré par git)
└── composer.json
```

---

## Base de données

Tables nécessaires :

```sql
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    type ENUM('revenu', 'depense') NOT NULL
);

CREATE TABLE transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL,
    description VARCHAR(255),
    type ENUM('revenu', 'depense') NOT NULL,
    categorie_id INT,
    date DATE NOT NULL,
    notes TEXT,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id)
);
```

---

## Sécurité

- Les mots de passe sont hashés avec `password_hash()` (bcrypt)
- Les pages protégées redirigent vers le login si la session est vide
- `config/settings.php` et `.env` sont dans le `.gitignore`

---

## Auteur

Ismail Zemmoury
