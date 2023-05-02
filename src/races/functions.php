<?php
    /** 
     * Recupere les races dans la base de données
     * @return array tableau associatif representant les races
     */
    function getRaces() {
        // On récupère la connexion à la base de données
        global $conn;

        // Récupération des races
        $query = "SELECT race_id, espece_id, race_name, poids_debut, poids_fin, age_adulte, age_age FROM fa.race";
        return $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

?>
