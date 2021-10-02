<?php
    require_once "../class/Connection/Connection.php";
    class User {
        private $name = "";
        private $lastname = "";
        private $connection = "";

        public function __construct()
        {
            $this->connection = new Connection;
        }

        public function get($id = null)
        {
            $query = "SELECT * FROM users";
            if ($id !== null) {
                $query += " WHERE id = " . $id; 
            }
            return $this->connection->getData($query);
        }
        
        public function store()
        {
            # code...
        }

        public function update()
        {
            # code...
        }

        public function delete()
        {
            # code...
        }
    }
