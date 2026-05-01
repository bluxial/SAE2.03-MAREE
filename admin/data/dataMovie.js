let HOST_URL = window.location.origin;

let DataMovie = {};

DataMovie.requestMovies = async function() {
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
    let data = await answer.json();
    return data;
};

DataMovie.add = async function(fdata) {
    let config = { method: "POST", body: fdata };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=addmovie", config);
    let data = await answer.json();
    return data;
};

DataMovie.requestMovieDetails = async function(id) {
    // on récupère les détails du film
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmoviedetail&id=" + id);
    let data = await answer.json();
    return data;
};

export { DataMovie };
