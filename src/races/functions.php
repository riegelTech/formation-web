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

        // execution de la requete
        $result_bdd = mysqli_query($conn, $query);

        $result = [];

        // Récupération de la totalité des résultats de l'execution de la requete
        while($row = mysqli_fetch_assoc($result_bdd)) {
            $result[] = $row;
        }

        // Retourne le tableau de résultats
        return $result;
    }

?>