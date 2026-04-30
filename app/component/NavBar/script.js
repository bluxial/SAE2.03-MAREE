let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, hHome, hProfile, profileName, changeProfileBtn) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{hProfile}}", hProfile);
  html = html.replace("{{profileName}}", profileName);
  html = html.replace("{{changeProfileBtn}}", changeProfileBtn || "");
  return html;
};

export { NavBar };
