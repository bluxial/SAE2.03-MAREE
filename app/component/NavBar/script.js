let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, hHome, hProfile, profileName) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{hProfile}}", hProfile);
  html = html.replace("{{profileName}}", profileName);
  return html;
};

export { NavBar };
