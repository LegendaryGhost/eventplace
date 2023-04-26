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

        public static function dataprovider(): array {
            $classic_case = [
                [
                    'status' => 'error',
                    'message' => ''
                ],
                [
                    'name' => 'John Doe',
                    'email' => 'johndoe@example.com',
                    'password' => 'azertyuiop123',
                    'type' => 'creator'
                ],
                400
            ];

            $cases = [
                [
                    ['message' => 'Invalid JSON body'],
                    null,
                    'don\'t merge body' => true
                ],
                [
                    ['message' => 'Missing information'],
                    ['name' => 'John Doe'],
                    'don\'t merge body' => true
                ],
                [
                    ['message' => 'Informations are required and can\'t be an empty string'],
                    ['email' => '']
                ],
                [
                    ['message' => 'Invalid email address'],
                    ['email' => 'johndoeexample.com']
                ],
                [
                    ['message' => 'Already signed email address'],
                    'already signed email' => true
                ],
                [
                    ['message' => 'Too short password (must contain at least 8 characters)'],
                    ['password' => 'azerty']
                ],
                [
                    ['message' => 'Incorrect user type (must be buyer or creator)'],
                    ['type' => 'creato']
                ],
                [
                    [
                        'status' => 'success',
                        'message' => 'The user has been registered'
                    ],
                    [],
                    200
                ]
            ];

            $testCases = [];

            foreach($cases as $case) {
                $newCase = [];
                $caseName = strtolower($case[0]['message']);
                $newCase[] = array_merge($classic_case[0], $case[0]);
                if(isset($case['don\'t merge body'])) {
                    $newCase[] = $case['don\'t merge body'] ? $case[1] : [];
                } else {
                    $newCase[] = array_merge($classic_case[1], isset($case[1]) ? $case[1] : []);
                }
                $newCase[] = isset($case[2]) ? $case[2] : $classic_case[2];

                if(isset($case['already signed email'])) {
                    $newCase[] = $case['already signed email'];
                }

                $testCases[$caseName] = $newCase;
            }

            return $testCases;
        }

        /** @dataProvider dataprovider */
        public function testRegisterAll(
            array $expectedResponse,
            array|null $parsedBody,
            int $expectedStatus,
            bool $alreadySigned = false
        ):void {
            $this->request->method('getParsedBody')->willReturn($parsedBody);

            if($expectedStatus === 200) {
                $this->userModel->expects($this->once())->method('create');
            }

            if($alreadySigned) {
                $this->userModel->method('findByEmail')->willReturn($parsedBody);
            }

            // call the register method
            $response = $this->userController->register($this->request, $this->response);

            // assert the response
            $this->assertSame($expectedStatus, $response->getStatusCode());
            $this->assertEquals($expectedResponse, json_decode($response->getBody(), true));
        }

    }

?>