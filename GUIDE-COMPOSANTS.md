# Guide des Composants

## 🧩 Qu'est-ce qu'un composant?

Un **composant** est une partie réutilisable de l'interface avec:
- **Template HTML** - La structure
- **Script JavaScript** - La logique
- **Style CSS** - L'apparence

---

## 📊 Composant NavBar

### Structure
```
component/NavBar/
├── template.html    # Structure de la navbar
├── script.js        # Logique et export
└── style.css        # Styles
```

### Comment ça fonctionne?

**template.html** - Structure:
```html
<nav class="navbar">
  <ul class="navbar__list">
    <li class="navbar__item" onclick="{{hAbout}}">About</li>
  </ul>
</nav>
```

**script.js** - Remplace les placeholders:
```javascript
NavBar.format = function (hAbout) {
  let html = template;
  html = html.replace("{{hAbout}}", hAbout);
  return html;
};
```

**Usage dans index.html**:
```javascript
import { NavBar } from "./component/NavBar/script.js";

// Afficher la navbar avec le bouton About
V.renderNavBar("C.handlerAbout()");
```

---

## 🎬 Composant Movie

### Structure
```
component/Movie/
├── template.html    # Structure de la grille
├── script.js        # Génère le HTML des films
└── style.css        # Styles de grille et cartes
```

### Comment ça fonctionne?

**template.html** - Conteneur:
```html
<div class="movie-grid">
  {{movies}}
</div>
```

**script.js** - Génère le HTML pour chaque film:
```javascript
Movie.format = function (movies) {
  // Générer une carte pour chaque film
  let moviesHTML = movies.map(movie => {
    return `
      <div class="movie-card">
        <img src="../server/images/${movie.image}" />
        <h3>${movie.name}</h3>
      </div>
    `;
  }).join('');
  
  // Remplacer le placeholder
  return template.replace("{{movies}}", moviesHTML);
};
```

**Usage dans index.html**:
```javascript
import { Movie } from "./component/Movie/script.js";

// Afficher les films
V.renderMovies(movies);
```

---

## 🔄 Flux de rafraîchissement

### Quand vous rajoutez un film à la BD:

```
1. Utilisateur recharge la page (F5)
   ↓
2. C.start() lance l'app
   ↓
3. C.loadMovies() requête le serveur
   ↓
4. server/script.php requête la BD
   ↓
5. SELECT FROM SAE203_Movie (y compris le nouveau film!)
   ↓
6. Le JSON retourne tous les films
   ↓
7. Movie.format() génère le HTML pour tous
   ↓
8. L'affichage met à jour automatiquement
```

---

## 📝 Comment créer un nouveau composant

Si vous voulez ajouter un composant **Details** pour voir les infos d'un film:

### 1. Structure de fichiers
```
component/Details/
├── template.html
├── script.js
└── style.css
```

### 2. template.html
```html
<div class="details">
  <h2>{{title}}</h2>
  <p>{{description}}</p>
</div>
```

### 3. script.js
```javascript
let template = await fetch("./component/Details/template.html")
  .then(r => r.text());

let Details = {};

Details.format = function(movie) {
  let html = template;
  html = html.replace("{{title}}", movie.name);
  html = html.replace("{{description}}", movie.description);
  return html;
};

export { Details };
```

### 4. style.css
```css
.details {
  padding: 2rem;
  background: #f5f5f5;
}
```

### 5. Utiliser dans index.html
```javascript
import { Details } from "./component/Details/script.js";

V.renderDetails = function(movie) {
  let details = document.querySelector("#details");
  details.innerHTML = Details.format(movie);
};

V.renderDetails(movies[0]);
```

---

## 🎨 Principes de design des composants

### ✅ BON
```javascript
// Composant réutilisable, paramétré
Movie.format = function(movies) {
  // Générer du HTML basé sur les données
}
```

### ❌ MAUVAIS
```javascript
// Composant qui récupère les données lui-même
Movie.format = function() {
  let movies = await fetch(...);
  // Difficile à réutiliser, mélange responsabilités
}
```

---

## 📚 À retenir

- **Un composant = Un fichier de template + logique JavaScript**
- **Les composants reçoivent des données en paramètre**
- **Les composants retournent du HTML**
- **Les composants sont réutilisables**
- **Sépars le template du code = meilleure maintenance**
