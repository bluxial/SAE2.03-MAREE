import { Movie } from "../Movie/script.js";

let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (categoryName, movies) {
  let count = movies.length;
  let moviesHtml = "";
  for (const movie of movies) {
    moviesHtml += Movie.format({ ...movie, category: "" });
  }
  let html = template;
  html = html.replace(/{{name}}/g, categoryName);
  html = html.replace(/{{count}}/g, count);
  html = html.replace(/{{plural}}/g, count > 1 ? "s" : "");
  html = html.replace(/{{movies}}/g, moviesHtml);
  return html;
};

export { MovieCategory };
