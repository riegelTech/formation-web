<?php
    // Se connecter à la base de données
    include("../db_connect.php");
    include("./functions.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    header('Content-Type: application/json');

    switch($request_method) {

        case 'GET':
            // Si race_id est renseigné, alors on remonte la race de l'animal
            $races = getRaces();
            echo json_encode($races, JSON_PRETTY_PRINT);
            break;

        default:
            // Requête invalide
            header("HTTP/1.0 405 Method Not Allowed");
            break;
        }
?>
