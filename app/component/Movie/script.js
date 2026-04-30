let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movie, isFavorite = null) {
  let html = template;
  html = html.replace(/{{image}}/g, "../server/images/" + movie.image);
  html = html.replace(/{{name}}/g, movie.name);
  html = html.replace(/{{category}}/g, movie.category || "");
  html = html.replace(/{{id}}/g, movie.id);
  let btn = "";
  if (isFavorite === null) {
    btn = "";
  } else if (isFavorite) {
    btn = '<button class="btn-favorite btn-favorite--done" onclick="event.stopPropagation()" disabled>★ Déjà en favori</button>';
  } else {
    btn = '<button class="btn-favorite" onclick="event.stopPropagation(); C.handlerAddFavorite(' + movie.id + ')">★ Ajouter aux favoris</button>';
  }
  html = html.replace(/{{favorite_button}}/g, btn);
  return html;
};

Movie.formatMany = function (movies, favorites = null) {
  let html = '<div class="movie-grid">';
  if (movies.length == 0) {
    return '<div class="no-movies">Aucun film disponible pour le moment.</div>';
  }
  for (const movie of movies) {
    let isFavorite = favorites === null ? null : favorites.some(function (f) { return f.id == movie.id; });
    html += Movie.format(movie, isFavorite);
  }
  html += "</div>";
  return html;
};

export { Movie };
