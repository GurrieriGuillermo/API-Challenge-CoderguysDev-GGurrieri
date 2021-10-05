<?php
    require_once "../class/Connection/Connection.php";
    require_once "../class/Services/ActionsService.php";
    
    $actions = new ActionsService;
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $response = $actions->acceptJoinRequest();
            break;
        
        default:
            header('Content-Type: application/json');
            $datosArray = $_respuestas->error_405();
            echo json_encode($datosArray);
            break;
    }
    echo json_encode($response);

