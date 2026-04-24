<?php
/**
 * Ce fichier contient toutes les fonctions qui réalisent des opérations
 * sur la base de données, telles que les requêtes SQL pour insérer, 
 * mettre à jour, supprimer ou récupérer des données.
 */

/**
 * Définition des constantes de connexion à la base de données.
 *
 * HOST : Nom d'hôte du serveur de base de données, ici "localhost".
 * DBNAME : Nom de la base de données
 * DBLOGIN : Nom d'utilisateur pour se connecter à la base de données.
 * DBPWD : Mot de passe pour se connecter à la base de données.
 */
define("HOST", "localhost");
define("DBNAME", "maree2");
define("DBLOGIN", "maree2");
define("DBPWD", "maree2");


function getAllMovies()
{
    // Connexion à la base de données
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    // Requête SQL pour récupérer le menu avec des paramètres
    $sql = "SELECT 
        m.id, 
        m.name, 
        m.image,
        c.name as category
    FROM SAE203_Movie m
    LEFT JOIN SAE203_Category c ON m.id_category = c.id";
    $stmt = $cnx->prepare($sql);
    // Exécute la requête SQL
    $stmt->execute();
    // Récupère les résultats de la requête sous forme d'objets
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res; // Retourne les résultats
}

function addMovie()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "INSERT INTO Movie (name, director, year, length, description, id_category, image, trailer, min_age) 
            VALUES (:name, :director, :year, :length, :description, :id_category, :image, :trailer, :min_age)";

    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':director', $_POST['director']);
    $stmt->bindParam(':year', $_POST['year']);
    $stmt->bindParam(':length', $_POST['length']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':id_category', $_POST['id_category']);
    $stmt->bindParam(':image', $_POST['image']);
    $stmt->bindParam(':trailer', $_POST['trailer']);
    $stmt->bindParam(':min_age', $_POST['min_age']);

    $stmt->execute();

    return "Le film a été ajouté avec succès.";
}