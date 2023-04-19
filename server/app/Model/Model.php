<?php

    namespace App\Model;

    use App\Database\Database;

    abstract class Model{

        /**
         * Nom de la table correspondant au modèle dans la base de données
         *
         * @var string
         */
        protected $table;
        protected $db;

        public function __construct(Database $db) {
            $this->db = $db;
            if(is_null($this->table)){
                $parts = explode('\\', get_class($this));
                $class_name = end($parts);
                $this->table = strtolower(str_replace('Model', '', $class_name)) . 's';
            }
        }
        
        /**
         * Exécute une requête
         *
         * @param string $statement
         * @param array $attributes
         * @param boolean $one
         * @return array|bool
         */
        public function query($statement, $attributes = null, $one = false):array|bool {
            if($attributes){
                return $this->db->prepare(
                    $statement,
                    $attributes,
                    str_replace('Model', 'Entity', get_class($this)),
                    $one
                );
            } else {
                return $this->db->query(
                    $statement,
                    str_replace('Model', 'Entity', get_class($this)),
                    $one
                );
            }
        }

        /**
         * Récupère toutes les lignes d'une table
         *
         * @return array
         */
        public function all():array{
            return $this->query('SELECT * FROM ' . $this->table . ';');
        }

        /**
         * Met à jour une ligne d'une table en fonction de son id
         *
         * @param int $id
         * @param array $fields
         * @return bool
         */
        public function update($id, $fields):bool {
            $sql_parts = [];
            $attributes = [];
            foreach($fields as $k => $v) {
                $sql_parts[] = "$k = ?";
                $attributes[] = $v;
            }
            $attributes[] = $id;
            $sql_part = implode(', ', $sql_parts);
            return $this->query(
                "UPDATE {$this->table} SET {$sql_part} WHERE id = ?",
                $attributes,
                true
            );
        }

        /**
         * Ajoute une nouvelle ligne dans la table
         *
         * @param array $fields
         * @return bool
         */
        public function create($fields):bool {
            $sql_parts = [];
            $attributes = [];
            foreach($fields as $k => $v) {
                $sql_parts[] = "$k = ?";
                $attributes[] = $v;
            }
            $sql_part = implode(', ', $sql_parts);
            return $this->query(
                "INSERT INTO {$this->table} SET {$sql_part}",
                $attributes,
                true
            );
        }

        /**
         * Retire une ligne de la table à partir de son id
         *
         * @param int $id
         * @return bool
         */
        public function delete($id):bool{
            return $this->query(
                "DELETE FROM {$this->table} WHERE id = ?",
                [$id],
                true
            );
        }

        public function extract($key, $value):array {
            $records = $this->all();
            $result = [];
            foreach($records as $v) {
                $result[$v->$key] = $v->$value;
            }
            return $result;
        }

        /**
         * Recherche une ligne d'une table à partir de son id
         *
         * @param int $id
         * @return array
         */
        public function find($id):array {
            return $this->query(
                'SELECT * FROM ' . $this->table .
                ' WHERE id = ?;',
                [$id],
                true
            );
        }

    }
    
?>