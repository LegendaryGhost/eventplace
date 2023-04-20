<?php

namespace App\Controller;

use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller {

    public function __construct() {}

    public function index(Request $request, Response $response, string $id):Response {
        $response = $response->withHeader('Content-type', 'application/json');
        $response->getBody()->write(json_encode([
            'id' => (int)$id
        ]));
        return $response;
    }

    public function register(Request $request, Response $response):Response {
        $data = $request->getParsedBody();
        $response = $response->withHeader('Content-type', 'application/json');
        //Vérifier le type de contenu
        if(is_null($data)) {
            $errorResponse = [
                "status" => "error",
                "message" => "Invalid JSON body"
            ];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withStatus(400);
        }

        // @todo Implement register
        // check if the request's body contains the correct informations
            // if correct, check if the email is already registered
                // if it is already registered, send an error message
                // if not, register the new user and send a success message
            // if not correct, send an error message

        $response->getBody()->write(json_encode($data));
        return $response;
    }

}

?>