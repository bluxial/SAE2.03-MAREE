let HOST_URL = "..";

let DataProfile = {};

DataProfile.add = async function (fdata) {
  let config = { method: "POST", body: fdata };
  let answer = await fetch(
    HOST_URL + "/server/script.php?todo=addprofile",
    config,
  );
  if (!answer.ok) throw new Error("Erreur serveur : " + answer.status);
  let data = await answer.json();
  return data;
};

DataProfile.read = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readprofiles");
  if (!answer.ok) throw new Error("Erreur serveur : " + answer.status);
  let data = await answer.json();
  return data;
};

DataProfile.save = async function (fdata) {
  let config = { method: "POST", body: fdata };
  let answer = await fetch(
    HOST_URL + "/server/script.php?todo=saveprofile",
    config,
  );
  if (!answer.ok) throw new Error("Erreur serveur : " + answer.status);
  let data = await answer.json();
  return data;
};

export { DataProfile };
