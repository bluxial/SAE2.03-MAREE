// ============================================================
// dataMovie.js - Module pour réclupérer les films du serveur
// ============================================================

// URL du serveur (relative, fonctionne en local ET en production)
let HOST_URL = "..";

// Objet contenant les données des films
let DataMovie = {};

/**
 * Récupère les films depuis le serveur PHP
 * @return Promise - Retourne les films en JSON
 */
DataMovie.requestMovies = async function () {
  try {
    // Faire une requête HTTP GET vers le serveur PHP
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");

    // Vérifier si la requête s'est bien déroulée
    if (!answer.ok) {
      throw new Error("Le serveur a retourné une erreur");
    }

    // Convertir la réponse en JSON et la retourner
    let data = await answer.json();
    return data;
  } catch (error) {
    // En cas d'erreur, afficher un message en console
    console.error("Erreur lors du chargement des films:", error);
    return [];
  }
};

DataMovie.requestMovieDetails = async function (id) {
  try {
    let answer = await fetch(
      HOST_URL + "/server/script.php?todo=readmoviedetail&id=" + id,
    );
    if (!answer.ok) {
      throw new Error("Erreur serveur");
    }
    let data = await answer.json();
    return data;
  } catch (error) {
    console.error("Erreur lors du chargement du film:", error);
    return null;
  }
};

DataMovie.requestMoviesGroupedByCategory = async function () {
  try {
    let answer = await fetch(
      HOST_URL + "/server/script.php?todo=readmoviesgroupedbycategory",
    );
    if (!answer.ok) {
      throw new Error("Le serveur a retourné une erreur");
    }
    let data = await answer.json();
    return data;
  } catch (error) {
    console.error("Erreur lors du chargement des films par catégorie:", error);
    return {};
  }
};

export { DataMovie };
