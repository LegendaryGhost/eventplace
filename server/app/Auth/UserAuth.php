<?php

    namespace App\Auth;

    use App\Model\UserModel;
    use Firebase\JWT\JWT;

    class UserAuth {

        private $encryptionAlgo = \PASSWORD_ARGON2ID;
        
        public function __construct(
            protected UserModel $userModel
        ){}

        /**
         * @param array $data An associative array with keys 'name', 'email', 'password' and 'type'
         * @throws \InvalidArgumentException If the required keys are not present in the array
         */
        public function register(array $data):bool {
            if(!isset($data['name'], $data['email'], $data['password'], $data['type'])) {
                throw new \InvalidArgumentException("Missing required keys 'name', 'email', 'password' or 'type' in the registration data");
            }

            $data['password'] = password_hash($data['password'], $this->encryptionAlgo);

            return $this->userModel->create($data);

        }

        /**
         * @param array $data An associative array with keys 'email' and 'password'
         * @return array An associative array with keys 'logged' which contains a boolean and 'message'
         * @throws \InvalidArgumentException If the required keys are not present in the array
         */
        public function login(array $data):array {
            if(!isset($data['email'], $data['password'])) {
                throw new \InvalidArgumentException("Missing required keys 'email' or 'password' in the login data");
            }

            $user = $this->userModel->findByEmail($data['email']);

            if($user) {
                $verified = password_verify($data['password'], $user['password']);
                if($verified) {
                    $token = $this->generateJWT($data['email'], SECRET_KEY);
                    return [
                        'logged' => true,
                        'message' => 'You\'re logged in',
                        'token' => $token
                    ];
                }
                return ['logged' => false, 'message' => 'Incorrect password'];
            }
            
            return ['logged' => false, 'message' => 'No account associated with your email address'];
        }

        private function generateJWT(string $email, string $secret): string {
            $payload = [
                'iss' => 'your-issuer',
                'sub' => $email,
                'iat' => time(),
                'exp' => time() + (60 * 60) // Token expires in 1 hour
            ];
        
            return JWT::encode($payload, $secret, 'HS256');
        }

    }

?>