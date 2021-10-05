<?php
    use Firebase\JWT\JWT;

    require_once "../class/Connection/Connection.php";
    require_once "../class/Validate/Validations.php";
    require_once '../php-jwt/src/JWT.php';

    class AuthUser {
        private $connection;
        protected $authUserId;
        protected $role;
        protected $token;
        protected $privateKey;
        
        public function __construct()
        {
            $this->connection = new Connection;
            $this->privateKey = "5KOB7oU5fM8oPZtRovGOl6FK5mxyIbAt";
        }

        public function login()
        {
            $request = Validations::manageValidations([]);

            if (!empty($request->email) && !empty($request->password)) {
                $query = "SELECT id, email, password, role FROM users WHERE email = '$request->email'";
                $results = $this->connection->getData($query);
                
                if ($results != false && password_verify($request->password, $results[0]['password'])) {
                    $this->authUserId = $results[0]['id'];
                    $this->role = $results[0]['role'];
                    $this->token = $this::authenticate();
                    $this::updateToken();
                    return ['token' => $this->token];
                } else {
                    return ['error' => 'Las credenciales no coinciden'];
                }
            }
        }

        public function register()
        {
            $request = Validations::manageValidations([]);
            
            if (!empty($request->email) && !empty($request->password)) {
                $hashPassword = password_hash($request->password, PASSWORD_BCRYPT);
                $query = "INSERT INTO users (email, password, name, lastname)
                    VALUES ('$request->email', '$hashPassword', '$request->name', '$request->lastname')";

                $results = $this->connection->nonQueryId($query);

                return ['success' => "Bienvenido $request->name!!!"];
            }else {
                return ['error' => 'Por favor, Ingresa correo y contraseña'];
            }
        }

        public function authenticate()
        {
            
            $time = time();
            $key = $this->privateKey;
            $token = array(
                'iat' => $time,
                'exp' => $time + (60 * 60), // 1 hora
                'id' => $this->authUserId,
                'role' => $this->role,
            );

            $jwt = JWT::encode($token, $key);
            return $jwt;
        }
        
        public function updateToken()
        {
            $query = "UPDATE users SET token = '$this->token' WHERE (id = $this->authUserId)";
            return $this->connection->nonQueryId($query);
        }
    }