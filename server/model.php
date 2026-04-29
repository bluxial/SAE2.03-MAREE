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
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getAllCategories()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "select id, name from SAE203_Category";
    $stmt = $cnx->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}

function addMovie($name, $image, $year, $description, $director, $trailer, $min_age, $length, $id_category)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO SAE203_Movie (name, image, year, description, director, trailer, min_age, length, id_category) VALUES (:name, :image, :year, :description, :director, :trailer, :min_age, :length, :id_category)";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':director', $director);
    $stmt->bindParam(':trailer', $trailer);
    $stmt->bindParam(':min_age', $min_age);
    $stmt->bindParam(':length', $length);
    $stmt->bindParam(':id_category', $id_category);
    return $stmt->execute();
}

function getMovieDetails($id)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT SAE203_Movie.*, SAE203_Category.name as category FROM SAE203_Movie LEFT JOIN SAE203_Category ON SAE203_Movie.id_category = SAE203_Category.id WHERE SAE203_Movie.id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_OBJ);
    return $res;
}

function getMoviesGroupedByCategory($age = 0)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $allCategories = $cnx->query("SELECT name FROM SAE203_Category ORDER BY name")->fetchAll(PDO::FETCH_OBJ);
    $grouped = [];
    foreach ($allCategories as $cat) {
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
    if ($age > 0) {
        $stmt->bindParam(':age', $age, PDO::PARAM_INT);
    }
    $stmt->execute();

    $movies = $stmt->fetchAll(PDO::FETCH_OBJ);

    $i = 0;
    $moviesCount = count($movies);
    while ($i < $moviesCount) {
        $movie = $movies[$i];
        $cat = $movie->category_name;
        $grouped[$cat][] = [
            'id' => $movie->id,
            'name' => $movie->name,
            'image' => $movie->image
        ];
        $i++;
    }

    return $grouped;
}

function addProfile($name, $avatar, $min_age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "INSERT INTO SAE203_Profile (name, avatar, min_age)
            VALUES (:name, :avatar, :min_age)";

    $stmt = $cnx->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':avatar', $avatar);
    $stmt->bindParam(':min_age', $min_age);

    return $stmt->execute();
}

function getAllProfiles()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    $sql = "SELECT id, name, avatar, min_age FROM SAE203_Profile";

    $stmt = $cnx->prepare($sql);

    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $res;
}