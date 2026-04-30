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
    $films = $cnx->query($sql)->fetchAll(PDO::FETCH_OBJ);
    return $films;
}

function getAllCategories()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $categories = $cnx->query("SELECT id, name FROM SAE203_Category")->fetchAll(PDO::FETCH_OBJ);
    return $categories;
}

function addMovie($name, $image, $year, $description, $director, $trailer, $min_age, $length, $id_category)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO SAE203_Movie (name, image, year, description, director, trailer, min_age, length, id_category) VALUES (:name, :image, :year, :description, :director, :trailer, :min_age, :length, :id_category)";
    $stmt = $cnx->prepare($sql);
    $ok = $stmt->execute(array(
        ':name' => $name,
        ':image' => $image,
        ':year' => $year,
        ':description' => $description,
        ':director' => $director,
        ':trailer' => $trailer,
        ':min_age' => $min_age,
        ':length' => $length,
        ':id_category' => $id_category
    ));
    return $ok;
}

function getMovieDetails($id)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT SAE203_Movie.*, SAE203_Category.name as category FROM SAE203_Movie LEFT JOIN SAE203_Category ON SAE203_Movie.id_category = SAE203_Category.id WHERE SAE203_Movie.id = :id";
    $stmt = $cnx->prepare($sql);
    $stmt->execute(array(':id' => $id));
    $film = $stmt->fetch(PDO::FETCH_OBJ);
    return $film;
}

function getMoviesGroupedByCategory($age = 0)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    // on crée un tableau avec toutes les catégories
    $grouped = array();
    $cats = $cnx->query("SELECT name FROM SAE203_Category ORDER BY name")->fetchAll(PDO::FETCH_OBJ);
    foreach ($cats as $cat) {
        $grouped[$cat->name] = array();
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
        $stmt->execute(array(':age' => $age));
    } else {
        $stmt->execute();
    }

    $films = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($films as $movie) {
        $grouped[$movie->category_name][] = array(
            'id' => $movie->id,
            'name' => $movie->name,
            'image' => $movie->image
        );
    }

    return $grouped;
}

function addProfile($name, $avatar, $min_age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "INSERT INTO SAE203_Profile (name, avatar, min_age) VALUES (:name, :avatar, :min_age)";
    $stmt = $cnx->prepare($sql);
    $ok = $stmt->execute(array(':name' => $name, ':avatar' => $avatar, ':min_age' => $min_age));
    return $ok;
}

function getAllProfiles()
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $profils = $cnx->query("SELECT id, name, avatar, min_age FROM SAE203_Profile")->fetchAll(PDO::FETCH_OBJ);
    return $profils;
}

function saveProfile($id, $name, $avatar, $min_age)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    // on vérifie si le profil existe déjà
    $sql_check = "SELECT id FROM SAE203_Profile WHERE id = :id";
    $stmt_check = $cnx->prepare($sql_check);
    $stmt_check->execute(array(':id' => $id));
    $existe = $stmt_check->fetch();

    if ($existe) {
        // le profil existe, on le modifie
        $sql = "UPDATE SAE203_Profile SET name = :name, avatar = :avatar, min_age = :min_age WHERE id = :id";
        $stmt = $cnx->prepare($sql);
        $ok = $stmt->execute(array(':id' => $id, ':name' => $name, ':avatar' => $avatar, ':min_age' => $min_age));
    } else {
        // le profil n'existe pas, on le crée
        $sql = "INSERT INTO SAE203_Profile (id, name, avatar, min_age) VALUES (:id, :name, :avatar, :min_age)";
        $stmt = $cnx->prepare($sql);
        $ok = $stmt->execute(array(':id' => $id, ':name' => $name, ':avatar' => $avatar, ':min_age' => $min_age));
    }

    return $ok;
}

function addFavorite($id_profile, $id_movie)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);

    // on vérifie si le favori existe déjà
    $sql_check = "SELECT id_profile FROM SAE203_Favorite WHERE id_profile = :id_profile AND id_movie = :id_movie";
    $stmt_check = $cnx->prepare($sql_check);
    $stmt_check->execute(array(':id_profile' => $id_profile, ':id_movie' => $id_movie));
    $existe = $stmt_check->fetch();

    if ($existe) {
        // le film est déjà dans les favoris
        return true;
    }

    // on ajoute le film aux favoris
    $sql = "INSERT INTO SAE203_Favorite (id_profile, id_movie) VALUES (:id_profile, :id_movie)";
    $stmt = $cnx->prepare($sql);
    $ok = $stmt->execute(array(':id_profile' => $id_profile, ':id_movie' => $id_movie));
    return $ok;
}

function getFavoritesByProfile($id_profile)
{
    $cnx = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, DBLOGIN, DBPWD);
    $sql = "SELECT m.id, m.name, m.image
            FROM SAE203_Favorite f
            JOIN SAE203_Movie m ON f.id_movie = m.id
            WHERE f.id_profile = :id_profile";
    $stmt = $cnx->prepare($sql);
    $stmt->execute(array(':id_profile' => $id_profile));
    $favoris = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $favoris;
}
