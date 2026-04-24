let templateFile = await fetch("./component/Form/template.html");
let template = await templateFile.text();

let Form = {};

Form.format = function () {
  return template;
};

Form.init = function () {
  let form = document.querySelector("#movie-form");
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(form);
    fetch("../server/script.php?todo=addmovie", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        return response.text().then(text => {
          console.log("Réponse du serveur:", text);
          return { status: response.status, text: text };
        });
      })
      .then((result) => {
        try {
          let data = JSON.parse(result.text);
          if (result.status === 200) {
            V.renderLog("✅ Film ajouté!");
            form.reset();
          } else {
            V.renderLog("❌ " + data);
          }
        } catch (e) {
          V.renderLog("❌ Erreur serveur: " + result.text);
        }
      })
      .catch((error) => {
        V.renderLog("❌ Erreur: " + error);
      });
  });
};

export { Form };
