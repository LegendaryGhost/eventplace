<?php

    use \Slim\Factory\AppFactory;
    use \Slim\Routing\RouteCollectorProxy;
    use \Slim\Handlers\Strategies\RequestResponseArgs;
    use \Psr\Http\Message\ResponseInterface as Response;
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Server\RequestHandlerInterface as RequestHandler;

    use App\Controller\UserController;

    // Création d'une instance de l'application Slim
    $app = AppFactory::create();
    $rraStrategy = new RequestResponseArgs();

    
    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();


    $app->add(function (Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    // Add Error Handling Middleware
    $app->addErrorMiddleware(true, false, false);

    // Définition de la route de la page d'accueil
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello World!');
        return $response;
    });

    $app->get('/error', function (Request $request, Response $response) {
        $response->getBody()->write('Page d\'erreur');
        return $response;
    });

    $app->group('/user', function (RouteCollectorProxy $group) {
        global $rraStrategy;
        $group->get('/{id:[0-9]+}', [UserController::class, 'index'])->setInvocationStrategy($rraStrategy);
        $group->post('/register', [UserController::class, 'register']);
    });

    // Autres définitions de routes
    // ...

    // Retourne l'instance de l'application
    return $app;

?>