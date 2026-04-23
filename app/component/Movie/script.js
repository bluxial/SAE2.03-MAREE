// ============================================================
// Movie/script.js - Composant pour afficher un film
// ============================================================

// Charger le template HTML du composant
let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

// Objet contenant les méthodes du composant Movie
let Movie = {};

/**
 * Formate un tableau de films en HTML
 * @param {Array} movies - Tableau de films à afficher
 * @return {String} - HTML généré
 */
Movie.format = function (movies) {
  let html = template;

  // Si aucun film, afficher un message
  if (!movies || movies.length === 0) {
    html = html.replace(
      "{{movies}}",
      '<div class="no-movies">Aucun film disponible pour le moment.</div>',
    );
    return html;
  }

  // Générer le HTML pour chaque film
  let moviesHTML = movies
    .map((movie) => {
      return `
      <div class="movie-card">
        <img src="../server/images/${movie.image}" alt="${movie.name}" class="movie-card__image" />
        <h3 class="movie-card__title">${movie.name}</h3>
        <p class="movie-card__category">${movie.category || "Sans catégorie"}</p>
      </div>
    `;
    })
    .join("");

  // Remplacer le placeholder dans le template
  html = html.replace("{{movies}}", moviesHTML);
  return html;
};

export { Movie };
