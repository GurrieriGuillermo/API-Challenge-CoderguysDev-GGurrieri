<?php
    use Firebase\JWT\JWT;
    use Firebase\JWT\ExpiredException;

    require_once '../php-jwt/src/JWT.php';
    require_once '../php-jwt/src/ExpiredException.php';
    require_once "../class/Connection/Connection.php";

    class Validations {

        static function manageValidations ($validations)
        {
            $valid = true;

            $request = Self::getRequest();
            $request->authUserId = Self::getUser($request);
            foreach ($validations as $validation) {
                switch ($validation) {
                    case 'isRoleOrganizer':
                        $valid = Self::isRole($request->token, 'organizer');
                        break;
                    case 'isRoleUser':
                        $valid = Self::isRole($request->token, 'user');
                        break;
                    case 'notIssetInvitation':
                        $valid = Self::notIssetInvitation($request);
                        break;
                    case 'issetInvitation':
                        $valid = Self::issetInvitation($request);
                        break;
                    case 'notIssetJoinRequest':
                        $valid = Self::notIssetJoinRequest($request);
                        break;
                    case 'issetJoinRequest':
                        $valid = Self::issetJoinRequest($request);
                        break;
                        
                    default:
                        # code...
                        break;
                }
                if ($valid == false) {
                    return false;
                }
            }
            return $request;
        }

        public function getRequest()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $request = new stdClass();
            foreach ($data as $key => $value)
            {
                $request->$key = $value;
            }
            return $request;
        }

        public function getUser($request) {
            if (isset($request->token)) {
                try {
                    $decoded = JWT::decode($request->token, "5KOB7oU5fM8oPZtRovGOl6FK5mxyIbAt", array('HS256'));
                    return $decoded->id;
                } catch (ExpiredException  $th) {
                    echo 'Caught exception: ',  $th->getMessage(), "\n";
                    return false;
                }
            }
            return false;
        }
        
        public function isRole($token, $role) {
            try {
                $decoded = JWT::decode($token, "5KOB7oU5fM8oPZtRovGOl6FK5mxyIbAt", array('HS256'));
                if ($decoded->role == $role) {
                    return true;
                }
            } catch (ExpiredException  $th) {
                echo 'Caught exception: ',  $th->getMessage(), "\n";
                return false;
            }
        }

        public function issetInvitation($request) {
            $connection = new Connection;

            $query = "SELECT count(*) as count FROM activities_users where user_id = $request->authUserId and activity_id = $request->activity_id and invite = 1";
            if ($connection->getData($query)[0]['count'] > 0) {
                return true;
            }
            return false;
        }

        public function issetJoinRequest($request) {
            $connection = new Connection;

            $query = "SELECT count(*) as count FROM activities_users where user_id = $request->user_id and activity_id = $request->activity_id  and pending = 1";
            if ($connection->getData($query)[0]['count'] > 0) {
                return true;
            }
            return false;
        }
        
        public function notIssetInvitation($request) {
            $connection = new Connection;

            $query = "SELECT count(*) as count FROM activities_users where user_id = $request->user_id and activity_id = $request->activity_id";
            if ($connection->getData($query)[0]['count'] > 0) {
                return false;
            }
            return true;
        }

        public function notIssetJoinRequest($request) {
            $connection = new Connection;

            $query = "SELECT count(*) as count FROM activities_users where user_id = $request->authUserId and activity_id = $request->activity_id";
            if ($connection->getData($query)[0]['count'] > 0) {
                return false;
            }
            return true;
        }


        
    }
