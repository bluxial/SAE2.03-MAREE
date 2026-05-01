let HOST_URL = window.location.origin;

let DataProfile = {};

DataProfile.add = async function(fdata) {
    let config = { method: "POST", body: fdata };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=addprofile", config);
    let data = await answer.json();
    return data;
};

DataProfile.read = async function() {
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readprofiles");
    let data = await answer.json();
    return data;
};

DataProfile.save = async function(fdata) {
    let config = { method: "POST", body: fdata };
    let answer = await fetch(HOST_URL + "/server/script.php?todo=saveprofile", config);
    let data = await answer.json();
    return data;
};

export { DataProfile };
