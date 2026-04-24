<?php

// Inclure le modèle pour accéder aux fonctions de base de données
require("model.php");

/**
 * Contrôleur pour récupérer les films
 * @return array - Retourne les films depuis la BDD
 */
function readMoviesController(){
    // Appeler la fonction du modèle
    $movies = getAllMovies();
    // Retourner les résultats
    return $movies;
}