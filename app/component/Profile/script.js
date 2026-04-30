let templateFile = await fetch("./component/Profile/template.html");
let template = await templateFile.text();

let Profile = {};

Profile.format = function(profile, favorites) {
    let html = template;
    html = html.replace("{{name}}", profile.name);

    let favHtml = "";
    if (favorites.length === 0) {
        favHtml = "<p>Aucun film dans vos favoris.</p>";
    } else {
        // on affiche chaque film favori
        for (let i = 0; i < favorites.length; i++) {
            let movie = favorites[i];
            favHtml += '<article class="fav-card cursor-pointer overflow-hidden" onclick="C.handlerDetail(' + movie.id + ')">';
            favHtml += '<img class="fav-card__image object-cover block" src="../server/images/' + movie.image + '" alt="' + movie.name + '" />';
            favHtml += '<p class="fav-card__title text-center font-bold">' + movie.name + '</p>';
            favHtml += '</article>';
        }
    }
    html = html.replace("{{favorites}}", favHtml);
    return html;
};

export { Profile };
