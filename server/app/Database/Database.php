<?php

    namespace App\Database;

    abstract class Database{

        public abstract function query($statement, $class_name = null, $one = false);

        public abstract function prepare($statement, $attributes, $class_name, $one = false);

    }

?>