<?php
    require_once "../class/Connection/Connection.php";
    require_once "../class/Services/UserService.php";
    
    $user = new UserService;
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $response = $user->get();
            break;
        case 'POST':
            $response = $user->store();
            break;
        case 'PUT':
            $response = $user->update();
            break;
        case 'DELETE':
            $response = $user->delete();
            break;
        
        default:
            header('Content-Type: application/json');
            $datosArray = $_respuestas->error_405();
            echo json_encode($datosArray);
            break;
    }
    echo json_encode($response);

