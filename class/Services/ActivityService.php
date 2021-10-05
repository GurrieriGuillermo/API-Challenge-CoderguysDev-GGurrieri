<?php

    require_once "../class/Connection/Connection.php";
    require_once "../class/Validate/Validations.php";

    class ActivityService {
        private $connection = "";

        public function __construct()
        {
            $this->connection = new Connection;
        }

        public function get()
        {
            $query = "SELECT * FROM activities";
            if (isset($_GET['id'])) {
                $query = $query . " WHERE id = " . $_GET['id']; 
            }
            return $this->connection->getData($query);
        }

        public function getActivityByCategory()
        {
            if (isset($_GET['category_id'])) {
                $category_id = $_GET["category_id"]; 
            }
            $query = "SELECT 
                activities.id AS id,
                activities.name AS name,
                activities.description AS description,
                activities.date AS date,
                activities.ubication AS ubication
            FROM categories,activities,activities_categories 
            WHERE 
                $category_id = activities_categories.category_id 
            AND
                activities_categories.activity_id = activities.id
            group by id";
            
            return $this->connection->getData($query);
        }
        
        public function store()
        {
            $validations = ['isRoleOrganizer'];
            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                $query = "INSERT INTO activities (id_user, name, description, date, ubication) 
                    VALUES 
                        (
                            '$request->authUserId',
                            '$request->name',
                            '$request->description',
                            '$request->date',
                            '$request->ubication'
                        )";
                return $this->connection->nonQueryId($query);
            }
            return 'Es posible que no tengas permisos para ejecutar esta función';
        }

        public function update()
        {
            $validations = ['isRoleOrganizer'];
            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                $query = "UPDATE activities SET
                    name = '$request->name',
                    description = '$request->description',
                    date = '$request->date',
                    ubication = '$request->ubication'
                WHERE (id = $request->id)";
            }

            $this->connection->nonQueryId($query);
            return ['success' => "Actividad actualizada"];
        }

        public function delete()
        {
            $validations = ['isRoleOrganizer'];
            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                $query = "DELETE FROM activities WHERE (id = $request->id)";
            }
            return $this->connection->nonQueryId($query);
        }
    }
