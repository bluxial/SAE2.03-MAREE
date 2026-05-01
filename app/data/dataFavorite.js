let HOST_URL = window.location.origin;

let DataFavorite = {};

DataFavorite.add = async function(id_profile, id_movie) {
    let fdata = new FormData();
    fdata.append("id_profile", id_profile);
    fdata.append("id_movie", id_movie);
    let answer = await fetch(HOST_URL + "/server/script.php?todo=addfavorite", {
        method: "POST",
        body: fdata
    });
    let data = await answer.json();
    return data;
};

DataFavorite.read = async function(id_profile) {
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readfavorites&id_profile=" + id_profile);
    let data = await answer.json();
    return data;
};

export { DataFavorite };
