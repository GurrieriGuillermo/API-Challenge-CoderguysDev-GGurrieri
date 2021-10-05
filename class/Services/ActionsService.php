<?php

    require_once "../class/Connection/Connection.php";
    require_once "../class/Validate/Validations.php";
    require_once "../class/Validate/Validations.php";
    require_once "../class/Validate/Validations.php";

    class ActionsService {
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
        
        public function actions()
        {
            $validations = ['isRoleUser'];
            $request =  Validations::manageValidations($validations);
            switch ($request->action) {
                case 'get-my-activities':
                    $response = $this->getMyActivities($request, 0);
                    break;
                case 'get-my-invitations':
                    $response = $this->getMyActivities($request, 1);
                    break;
            }
            return $response;
        }

        public function inviteRequest()
        {
            $validations = ['isRoleOrganizer', 'notIssetInvitation'];
            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                $query = "INSERT INTO activities_users (user_id, activity_id, invite, pending) VALUES ('$request->user_id', '$request->activity_id', 1, 0)";
                return $this->connection->nonQueryId($query);
            }
            return 'invalid data';
        }

        public function sendJoinRequest()
        {
            $validations = ['isRoleUser', 'notIssetJoinRequest'];
            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                $query = "INSERT INTO activities_users (user_id, activity_id, invite, pending) VALUES ('$request->authUserId', '$request->activity_id', 0, 1)";
                return $this->connection->nonQueryId($query);
            }
            return 'invalid data';
        }

        // organizador acepta/rechaza la solicitud a un usuario 
        public function acceptJoinRequest()
        {
            $validations = ['isRoleOrganizer', 'issetJoinRequest'];
            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                if ($request->accept == 1) {
                    $query = "UPDATE activities_users SET pending = 0 WHERE user_id = $request->user_id and activity_id = $request->activity_id";
                } else {
                    $query = "DELETE FROM activities_users WHERE user_id = $request->user_id and activity_id = $request->activity_id";
                }
                return $this->connection->nonQueryId($query);
            }
            return 'invalid data';
        }

        // usuario acepta/rechaza la invitacion a un evento 
        public function acceptInviteRequest()
        {
            $validations = ['isRoleUser', 'issetInvitation'];
            $request =  Validations::manageValidations($validations);
            if ($request != false) {
                if ($request->accept == 1) {
                    $query = "UPDATE activities_users SET invite = 0 WHERE user_id = $request->authUserId and activity_id = $request->activity_id";
                } else {
                    $query = "DELETE FROM activities_users WHERE user_id = $request->authUserId and activity_id = $request->activity_id";
                }
                return $this->connection->nonQueryId($query);
            }
            return 'invalid data';
        }

        public function getMyActivities($request, $invite)
        {
            $query = "SELECT 
                activities.id AS id,
                activities.name AS name,
                activities.description AS description,
                activities.date AS date,
                activities.ubication AS ubication
            FROM users,activities,activities_users 
            WHERE 
                $request->authUserId = activities_users.user_id 
            AND
                activities_users.activity_id = activities.id
            AND 
                activities_users.invite = $invite
            AND 
                activities_users.pending = 0
            group by id";
            
            return $this->connection->getData($query);
        }
    }
