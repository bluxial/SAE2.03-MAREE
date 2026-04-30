let HOST_URL = "https://mmi.unilim.fr/~maree2/SAE2.03-MAREE";

let DataFavorite = {};

DataFavorite.add = async function (id_profile, id_movie) {
  let fdata = new FormData();
  fdata.append("id_profile", id_profile);
  fdata.append("id_movie", id_movie);
  let answer = await fetch(HOST_URL + "/server/script.php?todo=addfavorite", {
    method: "POST",
    body: fdata,
  });
  if (!answer.ok) throw new Error("Erreur serveur : " + answer.status);
  return await answer.json();
};

DataFavorite.read = async function (id_profile) {
  let answer = await fetch(
    HOST_URL + "/server/script.php?todo=readfavorites&id_profile=" + id_profile,
  );
  if (!answer.ok) throw new Error("Erreur serveur : " + answer.status);
  return await answer.json();
};

export { DataFavorite };
