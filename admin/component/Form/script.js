let templateFile = await fetch("./component/Form/template.html");
let template = await templateFile.text();

let Form = {};

Form.format = function (handler) {
  let html = template;
  html = html.replace("{{handler}}", handler);
  return html;
};

export { Form };
