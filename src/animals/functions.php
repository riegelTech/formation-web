<?php

/**
 * Récupération paginée des animaux de la base de données
 * @param integer nombre de fiche par page
 * @param integer numérotation de page
 * @return array d'un tableau associatif par ligne animal (id/row)
 */
function getAnimals($nbAnimauxPage,$numeroPage) {
        // On récupère la connexion à la base de données
        global $conn;
        
        // Récupération du nombre de fiches animal totales
        // requete
        $queryTotalFichesAnimal = "SELECT count(animal_id) AS total FROM fa.animal WHERE deleted_at is null";
        
        // Execution de la requete
        $exect = mysqli_query($conn ,$queryTotalFichesAnimal);

        // Recupération du tableau associatif
        $fetch = mysqli_fetch_assoc($exect);

        // Récupération total issue de l'execution de la requete
        $total = $fetch['total'];

        // Déterminer le premier élément de la page
        $premierElementDeLaPage = ($numeroPage - 1) * $nbAnimauxPage;

        // requete de la sélection des animaux paginée
        $query = "SELECT * FROM fa.animal WHERE deleted_at is null ORDER BY animal_id ASC LIMIT $premierElementDeLaPage, $nbAnimauxPage";
        
        // initialisation du tableau de résultats
        $result = array("total" => $total, "items" => []);

        // execution de la requete
        $result_bdd = mysqli_query($conn, $query);
        
        // Récupération de la totalité des résultats de l'execution de la requete
        while($row = mysqli_fetch_assoc($result_bdd)) {
            $result["items"][] = $row;
        }
        
        // Retourne le tableau de résultats
        return $result;
}

/** 
 * Recupere un Animal dans la base de données
 * @param integer $id  ID de l'animal
 * @return array tableau associatif representant l'animal
 */
function getAnimal($id) {
         // On récupère la connexion à la base de données
         global $conn;
         // Requete
        $queryInfoAnimal = "SELECT * FROM fa.animal WHERE animal_id = $id";
        // Execution de la requette
        $result = mysqli_query($conn ,$queryInfoAnimal);
        // Récupération des résultats de la requete sous un tableau associatif
        $fetch = mysqli_fetch_assoc($result);
        // On retourne les résultats
        return $fetch;
}

/**
 * Sauvegarde un animal en base de données
 * @param integer Identifiant de l'animal
 * @param array tableau associatif representant l'animal
 * @return boolean la bonne exécution (ou non) de la requete
 */
function updateAnimal($id, $animal){
        // On récupère la connexion à la base de données
        global $conn;
        // Requete
        $query = "UPDATE fa.animal
        SET customer_id='"    . $animal['customer_id']     . "', 
            customer_email='" . $animal['customer_email']  . "', 
            espece_id="       . $animal['espece_id']       . ", 
            race_id="         . $animal['race_id']         . ", 
            stade_id="        . $animal['stade_id']        . ", 
            sousstade_id="    . $animal['sousstade_id']    . ", 
            date_naissance='" . $animal['date_naissance']  . "', 
            nom='"            . $animal['nom']             . "', 
            couleur='"        . $animal['couleur']         . "', 
            sexe='"           . $animal['sexe']            . "', 
            sterelise="       . $animal['sterelise']       . ", 
            activite='"       . $animal['activite']        . "', 
            pelage='"         . $animal['pelage']          . "', 
            poids_actuel='"   . $animal['poids_actuel']    . "', 
            poids_normal_theorique=" . $animal['poids_normal_theorique']. "
        WHERE animal_id = $id";
        // Execution de la requete
        return mysqli_query($conn, $query);
        // Fin
}

/**
 * Supprimer un animal en base de données
 * @param integer Identifiant de l'animal
 * @return boolean la bonne exécution (ou non) de la requete
 */
function SoftDeleteAnimal($id) {
        // On récupère la connexion à la base de données
        global $conn;
        // Requete : ajouter une date de suppression "deleted_at"
        $query = "UPDATE fa.animal SET deleted_at = CURRENT_TIMESTAMP WHERE animal_id = $id;";
        // Execution de la requete
        return mysqli_query($conn, $query);
}
?>
