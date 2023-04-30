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
        return $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

?>