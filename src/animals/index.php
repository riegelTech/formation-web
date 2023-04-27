<?php
    // Se connecter à la base de données
    include("../db_connect.php");
    include("./functions.php");
    $request_method = $_SERVER["REQUEST_METHOD"];

    header('Content-Type: application/json');
    
    function validator($paramName, $minValue, $defaultValue) {
        if (isset($_GET[$paramName]) && is_numeric($_GET[$paramName]) && intval($_GET[$paramName], 10) > $minValue) {
            return intval($_GET[$paramName], 10);

        }
        return $defaultValue;
    }

    switch($request_method) {

        case 'GET':     
            // Si animal_id est renseigné alors c'est que l'on remonte 1 animal
            $animalId = validator('animal_id', 1, null);
            if ($animalId !== null)
             {
                $animal = getAnimal($animalId);
                echo json_encode($animal, JSON_PRETTY_PRINT);
            }
            // Sinon on affiche la liste des animaux
            else {
                $page = validator('page', 1, 1);
                $pageSize = validator('pageSize', 1, 42);
                $animaux = getAnimals($pageSize, $page);
                echo json_encode($animaux, JSON_PRETTY_PRINT);
            }
            break;

        case 'PUT':
            $animalId = validator('animal_id', 1, null);
            $animalToUpdate = json_decode(file_get_contents("php://input"), true);
            $testUpdate = updateAnimal($animalId, $animalToUpdate);
            if ($testAnimal === false) {
                header("HTTP/1.0 500 Internal Server Error");
            }
            
            break;

        case 'DELETE':
            $animalId = validator('animal_id', 1, null);
            if ($animalId !== null) {
                $testDeleteAnimal = SoftDeleteAnimal($animalId);
                if ($testDeleteAnimal === false) {
                    header("HTTP/1.0 500 Internal Server Error");
                }
            }
            else {
                header("HTTP/1.0 400 Bad Request");
                echo 'Tu vas mettre un ID sale con ?';
            }
            break;

        default:
            // Requête invalide
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
?>
