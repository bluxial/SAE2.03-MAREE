let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movie) {
  let html = template;
  html = html.replace(/{{image}}/g, "../server/images/" + movie.image);
  html = html.replace(/{{name}}/g, movie.name);
  html = html.replace(/{{category}}/g, movie.category);
  return html;
};

Movie.formatMany = function (movies) {
  let html = '<div class="movie-grid">';
  if (movies.length == 0) {
    return '<div class="no-movies">Aucun film disponible pour le moment.</div>';
  }
  for (const movie of movies) {
    html += Movie.format(movie);
  }
  html += "</div>";
  return html;
};

export { Movie };
