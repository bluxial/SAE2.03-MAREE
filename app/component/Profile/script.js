let templateFile = await fetch("./component/Profile/template.html");
let template = await templateFile.text();

let Profile = {};

Profile.format = function (profile, favorites) {
  let html = template;
  html = html.replace(/{{name}}/g, profile.name);

  let favHtml = "";
  if (favorites.length === 0) {
    favHtml = "<p>Aucun film dans vos favoris.</p>";
  } else {
    for (let movie of favorites) {
      favHtml +=
        '<article class="fav-card" onclick="C.handlerDetail(' + movie.id + ')">' +
        '<img class="fav-card__image" src="../server/images/' + movie.image + '" alt="' + movie.name + '" />' +
        '<p class="fav-card__title">' + movie.name + "</p>" +
        "</article>";
    }
  }
  html = html.replace(/{{favorites}}/g, favHtml);
  return html;
};

export { Profile };
