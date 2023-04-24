<?php

    namespace Tests\Unit\Controller;

    use \App\Controller\UserController;
    use \App\Model\UserModel;

    use \PHPUnit\Framework\TestCase;
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Psr7\Factory\ResponseFactory;

    class UserControllerTest extends TestCase {

        protected $userController;
        protected $userModel;
        protected $response;
        protected $request;

        protected function setUp(): void {
            parent::setUp();
            $this->userModel = $this->createMock(UserModel::class);
            $this->userController = new UserController($this->userModel);
            $this->response = (new ResponseFactory())->createResponse();
            // $this->response = $this->createMock(Response::class);
            $this->request = $this->createMock(Request::class);
        }

        public function testRegisterWithInvalidJson() {

            $this->request->method('getParsedBody')->willReturn(null);
            
            $response = $this->userController->register($this->request, $this->response);

            $expectedResponse = [
                "status" => "error",
                "message" => "Invalid JSON body"
            ];
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
            
        }

        public function testRegisterWithMissingInfo() {
            // create a fake request
            $expectedResponse = [
                "status" => "error",
                "message" => "Missing information"
            ];

            $this->request->method('getParsedBody')->willReturn(['name' => 'John Doe']);

            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
        }

        public function testRegisterWithEmptyStringInfo() {
            // create a fake request
            $expectedResponse = [
                "status" => "error",
                "message" => "Informations are required and can't be an empty string"
            ];

            $body = [
                'name' => 'John Doe',
                'email' => '',
                'password' => 'azertyuiop123',
                'type' => 'creator'
            ];

            $this->request->method('getParsedBody')->willReturn($body);

            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
        }

        public function testRegisterWithInvalidEmail() {
            // create a fake request
            $expectedResponse = [
                "status" => "error",
                "message" => "Invalid email address"
            ];

            $body = [
                'name' => 'John Doe',
                'email' => 'johndoeexample.com',
                'password' => 'azertyuiop123',
                'type' => 'creator'
            ];

            $this->request->method('getParsedBody')->willReturn($body);

            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
        }

        public function testRegisterWithAlreadySignedEmail() {
            // create a fake request
            $expectedResponse = [
                "status" => "error",
                "message" => "Already signed email address"
            ];

            $body = [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => 'azertyuiop123',
                'type' => 'creator'
            ];

            $this->userModel->method('findByEmail')->willReturn($body);
            $this->request->method('getParsedBody')->willReturn($body);

            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
        }

        public function testRegisterWithTooShortPassword() {
            // create a fake request
            $expectedResponse = [
                "status" => "error",
                "message" => "Too short password (must contain at least 8 characters)"
            ];

            $body = [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => 'azerty',
                'type' => 'creator'
            ];

            $this->request->method('getParsedBody')->willReturn($body);

            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
        }

        public function testRegisterWithIncorrectUserType() {
            // create a fake request
            $expectedResponse = [
                "status" => "error",
                "message" => "Incorrect user type (must be buyer or creator)"
            ];

            $body = [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => 'azertyuiop123',
                'type' => 'creato'
            ];

            $this->request->method('getParsedBody')->willReturn($body);

            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
        }

        public function testRegisterWithCorrectInfo() {
            // create a fake request
            $expectedResponse = [
                'status' => 'success',
                'message' => 'The user has been registered'
            ];

            $correctBody = [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => 'azertyuiop123',
                'type' => 'creator'
            ];
            $this->request->method('getParsedBody')->willReturn($correctBody);

            $this->userModel->expects($this->once())->method('create')->with($correctBody);
            
            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame(200, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
        }

    }

?>