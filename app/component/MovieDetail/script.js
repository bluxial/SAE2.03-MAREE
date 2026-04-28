let templateFile = await fetch("./component/MovieDetail/template.html");
let template = await templateFile.text();

let MovieDetail = {};

MovieDetail.format = function (movie) {
  let html = template;
  html = html.replace(/{{image}}/g, "../server/images/" + movie.image);
  html = html.replace(/{{name}}/g, movie.name);
  html = html.replace(/{{year}}/g, movie.year);
  html = html.replace(/{{length}}/g, movie.length);
  html = html.replace(/{{category}}/g, movie.category);
  html = html.replace(/{{min_age}}/g, movie.min_age);
  html = html.replace(/{{director}}/g, movie.director);
  html = html.replace(/{{description}}/g, movie.description);
  html = html.replace(/{{trailer}}/g, movie.trailer);
  return html;
};

export { MovieDetail };
