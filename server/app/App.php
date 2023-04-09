<?php

    use Slim\Factory\AppFactory;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    // Création d'une instance de l'application Slim
    $app = AppFactory::create();

    $app->addRoutingMiddleware();

    // Add Error Handling Middleware
    $app->addErrorMiddleware(true, false, false);


    // Définition de la route de la page d'accueil
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello World');
        return $response;
    });

    // Autres définitions de routes
    // ...

    // Retourne l'instance de l'application
    return $app;

?>