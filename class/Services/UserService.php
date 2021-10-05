<?php
    require_once "../class/Connection/Connection.php";
    require_once "../class/Validate/Validations.php";
    class UserService {
        private $name = "";
        private $lastname = "";
        private $connection = "";

        public function __construct()
        {
            $this->connection = new Connection;
        }

        public function get()
        {
            $query = "SELECT * FROM users";
            if (isset($_GET['id'])) {
                $query = $query . " WHERE id = " . $_GET['id']; 
            }
            return $this->connection->getData($query);
        }
        
        public function store()
        {
            $validations = [];
            $request =  Validations::manageValidations($validations);
            
            if ($request != false) {
                $query = "INSERT INTO users (name, lastname) VALUES ('$request->name', '$request->lastname')";
                return $this->connection->nonQueryId($query);
            }
            return 'invalid data';
        }

        public function update()
        {
            $validations = [];

            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                $query = "UPDATE users SET name = '$request->name', lastname = '$request->lastname' WHERE (id = $request->id)";
            }
            return $this->connection->nonQueryId($query);

        }

        public function delete()
        {
            $validations = [];

            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                $query = "DELETE FROM users WHERE (id = $request->id)";
            }
            return $this->connection->nonQueryId($query);
        }
    }
