<?php

namespace App\Controller;

use \App\Auth\UserAuth;
use \App\Model\UserModel;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller {

    public function __construct(
        protected UserModel $userModel,
        protected UserAuth $userAuth
    ) {}

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

        $responseBody = [
            'status' => 'error',
            'message' => 'An error has occurred'
        ];

        // Check the body content
        if(is_null($data)) {
            $responseBody["message"] = "Invalid JSON body";
            $response->getBody()->write(json_encode($responseBody));
            return $response->withStatus(400);
        }

        // Check if the request's body contains all the correct informations
        if(isset(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['type']
        )) {

            foreach($data as $key => $value) {
                $data[$key] = trim(htmlspecialchars($value));
            }

            if(
                $data['name'] === '' ||
                $data['email'] === '' ||
                $data['password'] === '' ||
                $data['type'] === ''
            ) {
                $responseBody["message"] =  "Informations are required and can't be an empty string";
                $response->getBody()->write(json_encode($responseBody));
                return $response->withStatus(400);
            } elseif(!filter_var($data['email'], \FILTER_VALIDATE_EMAIL)) {
                $responseBody["message"] =  "Invalid email address";
                $response->getBody()->write(json_encode($responseBody));
                return $response->withStatus(400);
            } elseif(strlen($data['password']) < 8) {
                $responseBody["message"] = "Too short password (must contain at least 8 characters)";
                $response->getBody()->write(json_encode($responseBody));
                return $response->withStatus(400);
            } elseif($data['type'] !== 'creator' && $data['type'] !== 'buyer') {
                $responseBody["message"] = "Incorrect user type (must be buyer or creator)";
                $response->getBody()->write(json_encode($responseBody));
                return $response->withStatus(400);
            } elseif($this->userModel->findByEmail($data['email'])) {
                $responseBody["message"] =  "Already signed email address";
                $response->getBody()->write(json_encode($responseBody));
                return $response->withStatus(400);
            }

            $data['password'] = sha1($data['password']);

            $this->userAuth->register($data);
            $responseBody = [
                'status' => 'success',
                'message' => 'The user has been registered'
            ];
            $response->getBody()->write(json_encode($responseBody));
            return $response;

        }

        $responseBody["message"] = "Missing information";
        $response->getBody()->write(json_encode($responseBody));
        return $response->withStatus(400);
    }

    public function login(Request $request, Response $response): Response {
        $data = $request->getParsedBody();
        $response = $response->withHeader('Content-type', 'application/json');

        $responseBody = [
            'status' => 'error',
            'message' => 'An error has occurred'
        ];

        // Check the body content
        if(is_null($data)) {
            $responseBody["message"] = "Invalid JSON body";
            $response->getBody()->write(json_encode($responseBody));
            return $response->withStatus(400);
        }

        // Check if the request's body contains all the correct informations
        if(isset(
            $data['email'],
            $data['password']
        )) {

            foreach($data as $key => $value) {
                $data[$key] = trim(htmlspecialchars($value));
            }

            $this->userAuth->login($data);

        }

        $responseBody["message"] = "Missing information";
        $response->getBody()->write(json_encode($responseBody));
        return $response->withStatus(400);
    }

}

?>