<?php 
    // Se connecter à la base de données
    include("../db_connect.php");
    include("./functions.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    header('Content-Type: application/json');

    switch($request_method) {

        case 'GET':     
            // Si race est renseigné alors c'est que l'on remonte les races
            $races = getRaces();
            echo json_encode($races, JSON_PRETTY_PRINT);

        }
?>