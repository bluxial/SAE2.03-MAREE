let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function(movie, isFavorite) {
    let html = template;
    html = html.replace("{{image}}", "../server/images/" + movie.image);
    html = html.replaceAll("{{name}}", movie.name);
    html = html.replace("{{category}}", movie.category || "");
    html = html.replace("{{id}}", movie.id);

    let btn = "";
    if (isFavorite === null) {
        btn = "";
    } else if (isFavorite == true) {
        btn = '<button class="btn-favorite btn-favorite--done cursor-pointer text-center" onclick="event.stopPropagation()" disabled>★ Déjà en favori</button>';
    } else {
        btn = '<button class="btn-favorite cursor-pointer text-center" onclick="event.stopPropagation(); C.handlerAddFavorite(' + movie.id + ')">★ Ajouter aux favoris</button>';
    }
    html = html.replace("{{favorite_button}}", btn);
    return html;
};

Movie.formatMany = function(movies, favorites) {
    let html = '<div class="movie-grid">';
    if (movies.length == 0) {
        return '<div class="no-movies text-center">Aucun film disponible pour le moment.</div>';
    }
    // on boucle sur tous les films
    for (let i = 0; i < movies.length; i++) {
        let movie = movies[i];
        let isFavorite = null;
        if (favorites !== null) {
            // on cherche si le film est dans les favoris
            isFavorite = false;
            for (let j = 0; j < favorites.length; j++) {
                if (favorites[j].id == movie.id) {
                    isFavorite = true;
                }
            }
        }
        html += Movie.format(movie, isFavorite);
    }
    html += "</div>";
    return html;
};

export { Movie };
