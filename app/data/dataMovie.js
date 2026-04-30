let HOST_URL = "https://mmi.unilim.fr/~maree2/SAE2.03-MAREE";

let DataMovie = {};

/**
 * Récupère les films depuis le serveur PHP
 * @return Promise - Retourne les films en JSON
 */
DataMovie.requestMovies = async function () {
  try {
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");

    if (!answer.ok) {
      throw new Error("Le serveur a retourné une erreur");
    }

    let data = await answer.json();
    return data;
  } catch (error) {
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

DataMovie.requestMoviesGroupedByCategory = async function (age = 0) {
  try {
    let answer = await fetch(
      HOST_URL +
        "/server/script.php?todo=readmoviesgroupedbycategory&age=" +
        age,
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
