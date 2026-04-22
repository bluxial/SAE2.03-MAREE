<?php
// ============================================================
// MODEL.PHP - Couche modèle (accès à la base de données)
// ============================================================
// Ce fichier contient toutes les fonctions qui communiquent
// avec la base de données (requêtes SQL).
// ============================================================

// Constantes de connexion à la base de données
define("HOST", "localhost");
define("DBNAME", "maree2");
define("DBLOGIN", "maree2");
define("DBPWD", "maree2");

/**
 * Récupère tous les films de la base de données
 * @return array - Tableau des films (id, name, image)
 */
function getAllMovies(){
    try {
        // Créer une connexion PDO à la base de données
        $cnx = new PDO("mysql:host=".HOST.";dbname=".DBNAME, DBLOGIN, DBPWD);
        
        // Requête SQL pour récupérer les films
        $sql = "SELECT id, name, image FROM SAE203_Movie";
        
        // Préparer et exécuter la requête
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        
        // Récupérer tous les résultats en objets
        $res = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $res;
    } catch (PDOException $e) {
        // En cas d'erreur, enregistrer l'erreur
        error_log("Erreur BDD: " . $e->getMessage());
        return false;
    }
}