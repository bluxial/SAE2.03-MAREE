<?php

require("model.php");


function readMoviesController()
{
    $movies = getAllMovies();

    if ($movies === false || $movies === null) {
        return false;
    }
    return $movies;
}

function readCategoriesController()
{
    $categories = getAllCategories();
    if ($categories === false || $categories === null) {
        return false;
    }
    return $categories;
}

function addMovieController()
{
    $name = $_REQUEST['name'] ?? $_REQUEST['title'] ?? null;
    $image = $_REQUEST['image'] ?? null;
    $year = $_REQUEST['year'] ?? $_REQUEST['release_year'] ?? null;
    $description = $_REQUEST['description'] ?? null;
    $director = $_REQUEST['director'] ?? null;
    $trailer = $_REQUEST['trailer'] ?? null;
    $min_age = $_REQUEST['min_age'] ?? null;
    $length = $_REQUEST['length'] ?? null;
    $id_category = $_REQUEST['id_category'] ?? null;


    if (
        $name === null || $name === '' ||
        $image === null || $image === '' ||
        $year === null || $year === '' ||
        $description === null || $description === '' ||
        $director === null || $director === '' ||
        $trailer === null || $trailer === '' ||
        $min_age === null || $min_age === '' ||
        $length === null || $length === '' ||
        $id_category === null || $id_category === ''
    ) {

        return false;
        return "Tous les champs sont obligatoires et doivent être valides.";
    }

    $ok = addMovie($name, $image, $year, $description, $director, $trailer, $min_age, $length, $id_category);

    if ($ok != 0) {
        return "Le film $name a été ajouté avec succès !";
    } else {
        return "Une erreur est survenue lors de l'ajout du film.";
    }
}

function readMovieDetailController()
{

    $id = $_REQUEST['id'] ?? null;

    if ($id === null || $id === '') {
        return false;
    }
    $movie = getMovieDetails($id);
    if ($movie === false || $movie === null) {
        return false;
    }
    return $movie;
}

function readMoviesGroupedByCategoryController()
{
    $age = isset($_REQUEST['age']) ? intval($_REQUEST['age']) : 0;
    $movies = getMoviesGroupedByCategory($age);

    if ($movies === false || $movies === null) {
        return false;
    }
    return $movies;
}

function addProfileController()
{
    $name = $_REQUEST['name'] ?? null;
    $avatar = $_REQUEST['avatar'] ?? '';
    $min_age = $_REQUEST['min_age'] ?? null;

    if (
        $name === null || $name === '' ||
        $min_age === null || $min_age === ''
    ) {
        return false;
    }

    $ok = addProfile($name, $avatar, $min_age);

    if ($ok) {
        return "Le profil $name a été ajouté avec succès !";
    } else {
        return "Une erreur est survenue lors de l'ajout du profil.";
    }
}

function readProfilesController()
{
    $profiles = getAllProfiles();

    if ($profiles === false || $profiles === null) {
        return false;
    }
    return $profiles;
}