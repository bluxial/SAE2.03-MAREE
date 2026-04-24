<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

define("HOST", "localhost");
define("DBNAME", "maree2");
define("DBLOGIN", "maree2");
define("DBPWD", "maree2");

/**
 * Retourne une connexion PDO partagée (évite d'ouvrir plusieurs connexions).
 */
function getConnection()
{
    static $cnx = null;
    if ($cnx === null) {
        try {
            $cnx = new PDO(
                "mysql:host=" . HOST . ";dbname=" . DBNAME . ";charset=utf8",
                DBLOGIN,
                DBPWD,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            error_log("Erreur de connexion DB: " . $e->getMessage());
            throw new Exception("Erreur de connexion à la base de données", 500);
        }
    }
    return $cnx;
}

function getAllMovies()
{
    try {
        $cnx = getConnection();
        $sql = "SELECT 
                    m.id, 
                    m.name, 
                    m.image,
                    c.name AS category
                FROM SAE203_Movie m
                LEFT JOIN SAE203_Category c ON m.id_category = c.id";
        $stmt = $cnx->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (Exception $e) {
        error_log("Erreur getAllMovies: " . $e->getMessage());
        return [];
    }
}

/**
 * Insère un nouveau film dans la base de données.
 * Retourne true en cas de succès, false sinon.
 *
 * @param array $data  Tableau associatif avec les clés :
 *                     name, director, year, length, description,
 *                     id_category, image, trailer, min_age
 */
function addMovie($data)
{
    try {
        $cnx = getConnection();

        // Chercher l'ID de la catégorie par son nom
        $sqlCat = "SELECT id FROM SAE203_Category WHERE name = :category_name LIMIT 1";
        $stmtCat = $cnx->prepare($sqlCat);
        $stmtCat->execute([':category_name' => $data['id_category']]);
        $category = $stmtCat->fetch(PDO::FETCH_ASSOC);

        if (!$category) {
            error_log("Catégorie non trouvée: " . $data['id_category']);
            return false;
        }

        $category_id = $category['id'];

        $sql = "INSERT INTO SAE203_Movie 
                    (name, director, year, length, description, id_category, image, trailer, min_age)
                VALUES 
                    (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";

        $stmt = $cnx->prepare($sql);
        $result = $stmt->execute([
            ':name' => $data['name'],
            ':director' => $data['director'],
            ':year' => $data['year'],
            ':length' => $data['length'],
            ':description' => $data['description'],
            ':id_category' => $category_id,
            ':image' => $data['image'],
            ':trailer' => $data['trailer'],
            ':min_age' => $data['min_age'],
        ]);

        if (!$result) {
            error_log("SQL ERROR: Execute retourna false. Error: " . print_r($stmt->errorInfo(), true));
            return false;
        }

        error_log("Film inséré avec succès: " . $data['name']);
        return true;
    } catch (PDOException $e) {
        error_log("PDO Exception: " . $e->getMessage());
        return false;
    } catch (Exception $e) {
        error_log("Exception: " . $e->getMessage());
        return false;
    }
}

function getAllCategories()
{
    $cnx = getConnection();
    $sql = "SELECT id, name FROM SAE203_Category ORDER BY name ASC";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}