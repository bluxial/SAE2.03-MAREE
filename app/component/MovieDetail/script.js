let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function(movie, isFavorite) {
    let html = template;
    html = html.replace("{{image}}", "../server/images/" + movie.image);
    html = html.replaceAll("{{name}}", movie.name);
    html = html.replace("{{year}}", movie.year);
    html = html.replace("{{length}}", movie.length);
    html = html.replace("{{category}}", movie.category);
    html = html.replace("{{min_age}}", movie.min_age);
    html = html.replace("{{director}}", movie.director);
    html = html.replace("{{description}}", movie.description);
    html = html.replace("{{trailer}}", movie.trailer);

    let btn = "";
    if (isFavorite == true) {
        btn = '<button class="btn-favorite" disabled>Déjà dans vos favoris</button>';
    } else {
        btn = '<button class="btn-favorite" onclick="C.handlerAddFavorite(' + movie.id + ')">Ajouter aux favoris</button>';
    }
    html = html.replace("{{favorite_button}}", btn);
    return html;
};

export { MovieDetail };
