import { Movie } from "../Movie/script.js";

let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (categoryName, movies, favorites = null) {
  let count = movies.length;
  let moviesHtml = "";
  if (count === 0) {
    moviesHtml = "<p>Aucun film disponible pour votre tranche d'âge.</p>";
  } else {
    for (const movie of movies) {
      let isFavorite = favorites === null ? null : favorites.some(function (f) { return f.id == movie.id; });
      moviesHtml += Movie.format({ ...movie, category: "" }, isFavorite);
    }
  }
  let html = template;
  html = html.replace(/{{name}}/g, categoryName);
  html = html.replace(/{{count}}/g, count);
  html = html.replace(/{{plural}}/g, count > 1 ? "s" : "");
  html = html.replace(/{{movies}}/g, moviesHtml);
  return html;
};

export { MovieCategory };
