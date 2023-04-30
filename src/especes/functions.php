<?php
    /** 
     * Recupere les espèces dans la base de données
     * @return array tableau associatif representant les espèces
     */
    function getEspeces() {
        // On récupère la connexion à la base de données
        global $conn;

        // Récupération des especes
        $query = "SELECT espece_id, espece_name FROM fa.espece;";

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