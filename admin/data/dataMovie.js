let HOST_URL = ".."; //"http://mmi.unilim.fr/~????"; // CHANGE THIS TO MATCH YOUR CONFIG

let DataMovie = {};

DataMovie.requestMovies = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
  let data = await answer.json();
  return data;
};

DataMovie.add = async function (fdata) {
  let config = {
    method: "POST",
    body: fdata,
  };
  let answer = await fetch(
    HOST_URL + "/server/script.php?todo=addmovie",
    config,
  );
  let data = await answer.json();
  return data;
};

export { DataMovie };
