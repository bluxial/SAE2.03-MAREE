<?php

require("model.php");

function readMoviesController()
{
    return getAllMovies() ?? false;
}

function readCategoriesController()
{
    return getAllCategories() ?? false;
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
    }

    $ok = addMovie($name, $image, $year, $description, $director, $trailer, $min_age, $length, $id_category);
    return $ok ? "Le film $name a été ajouté avec succès !" : "Une erreur est survenue lors de l'ajout du film.";
}

function readMovieDetailController()
{
    $id = $_REQUEST['id'] ?? null;
    if (!$id)
        return false;
    return getMovieDetails($id) ?: false;
}

function readMoviesGroupedByCategoryController()
{
    $age = intval($_REQUEST['age'] ?? 0);
    return getMoviesGroupedByCategory($age) ?? false;
}

function addProfileController()
{
    $name = $_REQUEST['name'] ?? null;
    $avatar = $_REQUEST['avatar'] ?? '';
    $min_age = $_REQUEST['min_age'] ?? null;

    if ($name === null || $name === '' || $min_age === null || $min_age === '') {
        return false;
    }

    $ok = addProfile($name, $avatar, $min_age);
    return $ok ? "Le profil $name a été ajouté avec succès !" : "Une erreur est survenue lors de l'ajout du profil.";
}

function readProfilesController()
{
    return getAllProfiles() ?? false;
}

function saveProfileController()
{
    $id = ($_REQUEST['id'] ?? '') ?: null;
    $name = $_REQUEST['name'] ?? null;
    $avatar = $_REQUEST['avatar'] ?? '';
    $min_age = $_REQUEST['min_age'] ?? null;

    if ($name === null || $name === '' || $min_age === null || $min_age === '') {
        return false;
    }

    $ok = saveProfile($id, $name, $avatar, $min_age);
    return $ok ? "Le profil $name a été modifié avec succès !" : "Une erreur est survenue lors de la modification du profil.";
}

function addFavoriteController()
{
    $id_profile = $_REQUEST['id_profile'] ?? null;
    $id_movie = $_REQUEST['id_movie'] ?? null;

    if ($id_profile === null || $id_profile === '' || $id_movie === null || $id_movie === '') {
        return false;
    }

    $ok = addFavorite($id_profile, $id_movie);
    return $ok ? "Le film a été ajouté à vos favoris." : "Une erreur est survenue lors de l'ajout aux favoris.";
}

function readFavoritesController()
{
    $id_profile = $_REQUEST['id_profile'] ?? null;

    if ($id_profile === null || $id_profile === '') {
        return false;
    }

    return getFavoritesByProfile($id_profile) ?? false;
}