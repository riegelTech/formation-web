<?php

/**
 * Récupération paginée des animaux de la base de données
 * @param integer nombre de fiche par page
 * @param integer numérotation de page
 * @param integer|null especes
 * @param integer|null races
 * @return array d'un tableau associatif par ligne animal (id/row)
 */
function getAnimals($nbAnimauxPage,$numeroPage, $especeId, $raceId) {
        // On récupère la connexion à la base de données
        global $conn;
        // on crée des filtres pour simplifier la commande + si l'espece/races sont null ou non
        $filterEspece = "";
        if ($especeId !== null) {
                $filterEspece = "AND espece_id = :espece_id";
        }
        $filterRace = "";
        if ($raceId !== null) {
                $filterRace = "AND race_id = :race_id";
        }

        // Récupération du nombre de fiches animal totales qui ne sont pas supprimées avec deux filtres especes et races
        $query = "SELECT count(animal_id) AS total FROM fa.animal WHERE deleted_at IS NULL $filterEspece $filterRace";
        //execute la requete 
        $sth = $conn->prepare($query);
        //on regarde si especes et races ne sont pas nulles Bindvalue = remplace :: par la valeur qu'on veut
        if ($especeId !== null) {
                $sth->bindValue(':espece_id', intval($especeId), PDO::PARAM_INT);
        }
        if ($raceId !== null) {
                $sth->bindValue(':race_id', intval($raceId), PDO::PARAM_INT);
        }
        // on execute voir si ça marche 
        $sth->execute();
        // on fait le total de sth en tableau associatif
        $total = $sth->fetch(PDO::FETCH_ASSOC)["total"];
        
        // Déterminer le premier élément de la page
        $premierElementDeLaPage = ($numeroPage - 1) * $nbAnimauxPage;
        // requete de la sélection des animaux paginée
        $query = "SELECT * FROM fa.animal WHERE deleted_at IS NULL $filterEspece $filterRace ORDER BY animal_id ASC LIMIT :first, :nb";
        // Execution de la requette
        $sth = $conn->prepare($query);
        //on regarde si especes et races ne sont pas nulles Bindvalue = remplace :: par la valeur qu'on veut (on le communique au PDO)
        $sth->bindValue(':first', intval($premierElementDeLaPage), PDO::PARAM_INT);
        $sth->bindValue(':nb', intval($nbAnimauxPage), PDO::PARAM_INT);
        if ($especeId !== null) {
                $sth->bindValue(':espece_id', intval($especeId), PDO::PARAM_INT);
        }
        if ($raceId !== null) {
                $sth->bindValue(':race_id', intval($raceId), PDO::PARAM_INT);
        }
        // Execution de la requette
        $sth->execute();
        $animals = $sth->fetchAll(PDO::FETCH_ASSOC);

        // initialisation du tableau de résultats
        $result = array("total" => $total, "items" => $animals);
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
        $queryInfoAnimal = "SELECT * FROM fa.animal WHERE animal_id = :id";
        $sth = $conn->prepare($queryInfoAnimal);
        // Execution de la requette
        $sth->execute(['id' => $id]);
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        
        // On retourne les résultats
        return $result;
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
        SET customer_id=:customer_id, 
            customer_email=:customer_email, 
            espece_id=:espece_id, 
            race_id=:race_id, 
            stade_id=:stade_id, 
            sousstade_id=:sousstade_id, 
            date_naissance=:date_naissance, 
            nom=:nom, 
            couleur=:couleur,
            sexe=:sexe,
            sterelise=:sterelise,
            activite=:activite,
            pelage=:pelage,
            poids_actuel=:poids_actuel,
            poids_normal_theorique=:poids_normal_theorique
        WHERE animal_id = :animal_id";
        // Execution de la requete
        $sth = $conn->prepare($query);
        // Execution de la requette
        return $sth->execute([
                'customer_id' => $animal['customer_id'],
                'customer_email' => $animal['customer_email'],
                'espece_id' => $animal['espece_id'],
                'race_id' => $animal['race_id'],
                'stade_id' => $animal['stade_id'],
                'sousstade_id' => $animal['sousstade_id'],
                'date_naissance' => $animal['date_naissance'],
                'nom' => $animal['nom'],
                'couleur' => $animal['couleur'],
                'sexe' => $animal['sexe'],
                'sterelise' => $animal['sterelise'],
                'activite' => $animal['activite'],
                'pelage' => $animal['pelage'],
                'poids_actuel' => $animal['poids_actuel'],
                'poids_normal_theorique' => $animal['poids_normal_theorique'],
                'animal_id' => $id
        ]);
        // Fin
}

/**
 * Supprimer un animal en base de données
 * @param integer Identifiant de l'animal
 * @return boolean la bonne exécution (ou non) de la requete
 */
function softDeleteAnimal($animalId) {
        // On récupère la connexion à la base de données
        global $conn;
        // Requete : ajouter une date de suppression "deleted_at"
        $query = "UPDATE fa.animal SET deleted_at = CURRENT_TIMESTAMP WHERE animal_id = :id;";
        $sth = $conn->prepare($query);
        // Execution de la requette
        return $sth->execute(['id' => $animalId]);
}
?>
