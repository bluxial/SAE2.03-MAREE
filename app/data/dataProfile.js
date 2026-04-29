let HOST_URL = "..";

let DataProfile = {};

DataProfile.read = async function () {
  try {
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readprofiles");
    if (!answer.ok) throw new Error("Erreur serveur");
    let data = await answer.json();
    return data;
  } catch (error) {
    console.error("Erreur lors du chargement des profils:", error);
    return [];
  }
};

export { DataProfile };
