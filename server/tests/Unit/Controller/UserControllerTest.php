<?php

    namespace Tests\Unit\Controller;

    use \App\Controller\UserController;

    use \PHPUnit\Framework\TestCase;
    use \Slim\Psr7\Factory\ServerRequestFactory;
    use \Slim\Psr7\Factory\ResponseFactory;
    use \Slim\Psr7\Uri;
    use \Slim\Psr7\Stream;

    class UserControllerTest extends TestCase {

        protected $userController;

        protected function setUp() {
            parent::setUp();
            $this->userController = new UserController();
        }

        /** @test */
        public function it_returns_the_correct_response_when_registering_with_invalid_json() {

            $stream = new Stream(fopen('php://temp', 'r+'));
            fwrite($stream->detach(), 'Invalid JSON');
            if ($stream->isSeekable()) {
                $stream->rewind();
            }


            $request = ServerRequestFactory::createFromGlobals()
                ->withMethod('POST')
                ->withUri(new Uri('', 'eventplace-server.com', null, '/user/register'))
                ->withHeader('Content-Type', 'application/json')
                ->withBody($stream);

            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse();
            $response = $this->userController->register($request, $response);

            $expectedResponse = [
                "status" => "error",
                "message" => "Invalid JSON body"
            ];
            $this->assertSame(400, $response->getStatusCode());
            $this->assertSame(json_encode($expectedResponse), (string)$response->getBody());
            
        }

        /** @test */
        public function it_returns_the_correct_response_when_registering_with_incorrect_json() {
            // @todo Implement
            // create a fake request

            // call the register method

            // assert the response
        }

    }

?>