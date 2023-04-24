<?php

    namespace App\Model;

    class UserModel extends Model {

        /**
         * Recherche un utilisateur à partir de son email
         *
         * @param string $email
         * @return array
         */
        public function findByEmail($email):array {
            return $this->query(
                'SELECT * FROM ' . $this->table .
                ' WHERE email = ?;',
                [$email],
                true
            );
        }

    }

?>