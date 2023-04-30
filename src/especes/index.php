<?php
    // Se connecter à la base de données
    include("../db_connect.php");
    include("./functions.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    header('Content-Type: application/json');

    switch($request_method) {

        case 'GET':
            // Si espece_id est renseigné, alors on remonte l'espèce de l'animal
            $especes = getEspeces();
            echo json_encode($especes, JSON_PRETTY_PRINT);

        }
?>