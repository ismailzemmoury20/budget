-- Structure de la base BudgetTracker
-- À importer dans phpMyAdmin (MAMP) : base budgettracker_db → onglet "SQL" ou "Importer"

CREATE DATABASE IF NOT EXISTS budgettracker_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE budgettracker_db;

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    type ENUM('revenu', 'depense') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS transaction (
    id INT AUTO_INCREMENT PRIMARY KEY,
    montant DECIMAL(10,2) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    type ENUM('revenu', 'depense') NOT NULL,
    categorie_id INT DEFAULT NULL,
    date DATE NOT NULL,
    notes TEXT DEFAULT NULL,
    FOREIGN KEY (categorie_id) REFERENCES categorie(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
