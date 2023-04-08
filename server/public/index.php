<?php

    // Charger les dépendances de Composer
    require __DIR__ . '/../vendor/autoload.php';

    // Charger les variables d'environnement
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    // Initialiser l'application
    // require __DIR__ . '/../app/bootstrap.php';
    // $app = new App\Application();
    // $app->run();


?>