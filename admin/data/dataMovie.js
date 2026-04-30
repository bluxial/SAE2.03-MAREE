let HOST_URL = "https://mmi.unilim.fr/~maree2/SAE2.03-MAREE"; //"http://mmi.unilim.fr/~????"; // CHANGE THIS TO MATCH YOUR CONFIG

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
  let data = await answer.json();
  return data;
};

DataMovie.add = async function (fdata) {
  let config = { method: "POST", body: fdata };
  let answer = await fetch(
    HOST_URL + "/server/script.php?todo=addmovie",
    config,
  );
  if (!answer.ok) {
    throw new Error("Erreur serveur : " + answer.status);
  }
  let data = await answer.json();
  return data;
};

DataMovie.requestMovieDetails = async function (id) {
  try {
    let answer = await fetch(
      HOST_URL + "/server/script.php?todo=readmoviedetail&id=" + id,
    );
    if (!answer.ok) throw new Error("Erreur serveur");
    let data = await answer.json();
    return data;
  } catch (error) {
    console.error("Erreur lors du chargement du film:", error);
    return null;
  }
};

export { DataMovie };
