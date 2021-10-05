<?php
    require_once "../class/Connection/Connection.php";
    require_once "../class/Services/ActivityService.php";
    
    $activity = new ActivityService;
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $response = $activity->get();
            break;
        case 'POST':
            $response = $activity->store();
            break;
        case 'PUT':
            $response = $activity->update();
            break;
        case 'DELETE':
            $response = $activity->delete();
            break;
        
        default:
            header('Content-Type: application/json');
            $datosArray = $_respuestas->error_405();
            echo json_encode($datosArray);
            break;
    }
    echo json_encode($response);

