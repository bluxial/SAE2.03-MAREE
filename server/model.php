<?php

define("HOST", "localhost");
define("DBNAME", "maree2");
define("DBLOGIN", "maree2");
define("DBPWD", "maree2");

function getAllMovies()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT SAE203_Movie.id, SAE203_Movie.name, SAE203_Movie.image, SAE203_Category.name AS category
            FROM SAE203_Movie
            LEFT JOIN SAE203_Category ON SAE203_Movie.id_category = SAE203_Category.id";
    return $cnx->query($sql)->fetchAll(PDO::FETCH_OBJ);
}

function getAllCategories()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    return $cnx->query("select id, name from SAE203_Category")->fetchAll(PDO::FETCH_OBJ);
}

function addMovie($name, $image, $year, $description, $director, $trailer, $min_age, $length, $id_category)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO SAE203_Movie (name, image, year, description, director, trailer, min_age, length, id_category) VALUES (:name, :image, :year, :description, :director, :trailer, :min_age, :length, :id_category)";
    $stmt = $cnx->prepare($sql);
    return $stmt->execute([
        ':name' => $name,
        ':image' => $image,
        ':year' => $year,
        ':description' => $description,
        ':director' => $director,
        ':trailer' => $trailer,
        ':min_age' => $min_age,
        ':length' => $length,
        ':id_category' => $id_category
    ]);
}

function getMovieDetails($id)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT SAE203_Movie.*, SAE203_Category.name as category FROM SAE203_Movie LEFT JOIN SAE203_Category ON SAE203_Movie.id_category = SAE203_Category.id WHERE SAE203_Movie.id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

function getMoviesGroupedByCategory($age = 0)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $grouped = [];
    foreach ($cnx->query("SELECT name FROM SAE203_Category ORDER BY name")->fetchAll(PDO::FETCH_OBJ) as $cat) {
        $grouped[$cat->name] = [];
    }

    $sql = "SELECT m.id, m.name, m.image, c.name AS category_name 
            FROM SAE203_Movie m
            JOIN SAE203_Category c ON m.id_category = c.id";
    if ($age > 0) {
        $sql .= " WHERE m.min_age <= :age";
    }
    $sql .= " ORDER BY c.name, m.name";

    $stmt = $cnx->prepare($sql);
    $stmt->execute($age > 0 ? [':age' => $age] : []);

    foreach ($stmt->fetchAll(PDO::FETCH_OBJ) as $movie) {
        $grouped[$movie->category_name][] = [
            'id' => $movie->id,
            'name' => $movie->name,
            'image' => $movie->image
        ];
    }

    return $grouped;
}

function addProfile($name, $avatar, $min_age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO SAE203_Profile (name, avatar, min_age) VALUES (:name, :avatar, :min_age)";
    return $cnx->prepare($sql)->execute([':name' => $name, ':avatar' => $avatar, ':min_age' => $min_age]);
}

function getAllProfiles()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    return $cnx->query("SELECT id, name, avatar, min_age FROM SAE203_Profile")->fetchAll(PDO::FETCH_OBJ);
}

function saveProfile($id, $name, $avatar, $min_age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO SAE203_Profile (id, name, avatar, min_age)
            VALUES (:id, :name, :avatar, :min_age)
            ON DUPLICATE KEY UPDATE name = VALUES(name), avatar = VALUES(avatar), min_age = VALUES(min_age)";
    return $cnx->prepare($sql)->execute([':id' => $id, ':name' => $name, ':avatar' => $avatar, ':min_age' => $min_age]);
}