<?php

    // Charger les dépendances de Composer
    require_once __DIR__ . '/../vendor/autoload.php';

    // Charger les variables d'environnement
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    // Initialiser l'application
    // require __DIR__ . '/../app/bootstrap.php';
    $app = require_once './../app/App.php';
    $app->run();


?>