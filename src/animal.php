<?php
    // Se connecter à la base de données
    include("db_connect.php");
    $request_method = $_SERVER["REQUEST_METHOD"];
    function getAnimal($pas,$numeroPage)
    {
        global $conn;
        /*nombre d'items total*/

        /*requete*/
        $queryTotalItems = "SELECT count(animal_id) AS total FROM fa.animal";
        
        /*Execution de la requete*/
        $query2 = mysqli_query($conn ,$queryTotalItems);

        /*Recupération du tableau associatif*/
        $fetch2 = mysqli_fetch_assoc($query2);


        $total2 = $fetch2['total'];

/*Définition du nombre de pages*/
        $nbPages = ceil($total2 / $pas);


/* Premier élément de la page */

        $premierElementDeLaPage = ($numeroPage - 1) * $pas;


        $query = "SELECT * FROM fa.animal ORDER BY animal_id ASC LIMIT $premierElementDeLaPage, $pas";
        $result = array("total" => $total2, "items" => []);

        $result_bdd = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result_bdd))
        {
            $result["items"][] = $row;
        }
        return $result;
    }
    switch($request_method)
    {
        case 'GET':
            {
                $page = 1;
                $pageSize = 42;
                if (isset($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'], 10) > 1) {
                    $page = intval($_GET['page'], 10);
                }
                if (isset($_GET['pageSize']) && is_numeric($_GET['pageSize']) && intval($_GET['pageSize'], 10) > 0) {
                    $pageSize = intval($_GET['pageSize'], 10);
                }
               
                $animaux = getAnimal($pageSize, $page);
                header('Content-Type: application/json');
                echo json_encode($animaux, JSON_PRETTY_PRINT);
            }
            break;
        default:
            // Requête invalide
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
?>