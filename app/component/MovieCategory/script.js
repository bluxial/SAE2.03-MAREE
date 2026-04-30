import { Movie } from "../Movie/script.js";

let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function(categoryName, movies, favorites) {
    let count = movies.length;
    let moviesHtml = "";
    if (count === 0) {
        moviesHtml = "<p>Aucun film disponible pour votre tranche d'âge.</p>";
    } else {
        for (let i = 0; i < movies.length; i++) {
            let movie = movies[i];
            // on cherche si le film est dans les favoris
            let isFavorite = null;
            if (favorites !== null) {
                isFavorite = false;
                for (let j = 0; j < favorites.length; j++) {
                    if (favorites[j].id == movie.id) {
                        isFavorite = true;
                    }
                }
            }
            // on crée un objet film sans la catégorie pour l'affichage
            let movieSansCategorie = {};
            movieSansCategorie.id = movie.id;
            movieSansCategorie.name = movie.name;
            movieSansCategorie.image = movie.image;
            movieSansCategorie.category = "";
            moviesHtml += Movie.format(movieSansCategorie, isFavorite);
        }
    }
    let html = template;
    html = html.replace("{{name}}", categoryName);
    html = html.replace("{{count}}", count);
    html = html.replace("{{plural}}", count > 1 ? "s" : "");
    html = html.replace("{{movies}}", moviesHtml);
    return html;
};

export { MovieCategory };
