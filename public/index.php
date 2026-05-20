<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

$availableRoutes = [
    'landing'       => 'landingController',
    'home'          => 'homeController',
    'add'           => 'addController',
    'categorie'     => 'categorieController',
    'login'         => 'loginController',
    'register'      => 'registerController',
    'deconnexion'   => 'deconnexionController',
];

// Pages qui nécessitent d'être connecté
$protectedRoutes = ['home', 'add', 'categorie', 'deconnexion'];

$p = $_GET['p'] ?? 'landing';

// Redirection si non connecté et page protégée
if (in_array($p, $protectedRoutes) && empty($_SESSION['user'])) {
    header('Location: index.php?p=login');
    exit();
}

// Redirection si connecté et tente d'accéder à login, register ou landing
if (in_array($p, ['login', 'register', 'landing']) && !empty($_SESSION['user'])) {
    header('Location: index.php?p=home');
    exit();
}

if (array_key_exists($p, $availableRoutes)) {
    $controllerName = 'App\\Controllers\\' . $availableRoutes[$p];
    $controller = new $controllerName();
    $controller->index();
} else {
    $controllerName = 'App\\Controllers\\landingController';
    $controller = new $controllerName();
    $controller->index();
}
