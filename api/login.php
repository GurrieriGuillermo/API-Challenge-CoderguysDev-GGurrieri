<?php
    require_once "../class/Connection/Connection.php";
    require_once "../class/Auth/AuthUser.php";
    
    $authUser = new AuthUser;
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $response = $authUser->login();
            break;
        
        default:
            header('Content-Type: application/json');
            $datosArray = $_respuestas->error_405();
            echo json_encode($datosArray);
            break;
    }
    echo json_encode($response);


