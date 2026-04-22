# SAE2.03 - MAREE - Architecture du Projet

## 📚 Vue d'ensemble

Ce projet est une **application web** pour afficher une liste de films depuis une base de données.

### Structure du projet:
```
SAE2.03-MAREE/
├── app/                    # Frontend (HTML, CSS, JavaScript)
│   ├── index.html
│   ├── css/
│   ├── data/
│   │   └── dataMovie.js    # Module pour les requêtes HTTP
│   └── component/
│       ├── NavBar/         # Composant barre de navigation
│       └── Movie/          # Composant pour afficher les films
├── server/                 # Backend (PHP)
│   ├── script.php          # Point d'entrée des requêtes
│   ├── controller.php      # Contrôleurs
│   ├── model.php           # Accès à la base de données
│   └── images/             # Images des films
```

---

## 🏗️ Architecture MVC

Le projet utilise le pattern **MVC (Model-View-Controller)**:

### 1️⃣ **MODEL** (model.php)
- Contient les fonctions qui accèdent à la **base de données**
- Récupère les données

### 2️⃣ **CONTROLLER** (controller.php)
- Traite les **requêtes HTTP**
- Appelle les fonctions du modèle
- Retourne les résultats

### 3️⃣ **VIEW** (app/index.html + composants)
- Affiche les données à l'écran
- Récupère les données via JavaScript
- Génère le HTML

---

## 🔄 Flux de données

```
1. L'utilisateur charge app/index.html dans le navigateur
   ↓
2. JavaScript (app/index.html) démarre l'application C.start()
   ↓
3. DataMovie.requestMovies() fait une requête HTTP
   └─ GET /server/script.php?todo=readmovies
   ↓
4. script.php reçoit la requête et appelle readMoviesController()
   ↓
5. controller.php appelle getAllMovies() du model
   ↓
6. model.php requête la base de données
   └─ SELECT id, name, image FROM SAE203_Movie
   ↓
7. Les films sont retournés en JSON
   ↓
8. JavaScript affiche les films avec le composant Movie
```

---

## 📝 Comment ça marche

### Phase 1: Démarrage (app/index.html)

```javascript
// Importer les modules
import { NavBar } from "./component/NavBar/script.js";
import { Movie } from "./component/Movie/script.js";
import { DataMovie } from "./data/dataMovie.js";

// Créer un contrôleur
let C = {};

// Fonction pour charger les films
C.loadMovies = async function () {
  let moviesData = await DataMovie.requestMovies();
  V.renderMovies(moviesData);
};

// Démarrer l'app
C.start = function () {
  V.renderNavBar("C.handlerAbout()");
  C.loadMovies();
};

// Lancer l'app
C.start();
```

### Phase 2: Récupérer les films (app/data/dataMovie.js)

```javascript
// URL du serveur (relative, fonctionne partout)
let HOST_URL = "..";

// Objet pour les données
let DataMovie = {};

// Méthode pour requêter le serveur
DataMovie.requestMovies = async function() {
  try {
    // Faire une requête HTTP GET
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
    
    // Vérifier que c'est OK
    if (!answer.ok) {
      throw new Error("Erreur serveur");
    }
    
    // Convertir en JSON et retourner
    let data = await answer.json();
    return data;
  } catch (error) {
    console.error("Erreur:", error);
    return [];
  }
}
```

### Phase 3: Traiter la requête (server/)

**script.php** reçoit la requête:
- Regarde le paramètre `todo=readmovies`
- Appelle `readMoviesController()`

**controller.php** traite la requête:
```php
function readMoviesController(){
  // Appeler le modèle
  $movies = getAllMovies();
  return $movies;
}
```

**model.php** accède à la base de données:
```php
function getAllMovies(){
  // Se connecter à la BDD
  $cnx = new PDO("mysql:host=localhost;dbname=maree2", "maree2", "maree2");
  
  // Requête SQL
  $sql = "SELECT id, name, image FROM SAE203_Movie";
  
  // Exécuter et retourner
  $stmt = $cnx->prepare($sql);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_OBJ);
}
```

### Phase 4: Afficher les films (app/component/Movie/)

Le composant Movie formate les films en HTML:

```javascript
Movie.format = function (movies) {
  // Générer du HTML pour chaque film
  let moviesHTML = movies.map(movie => {
    return `
      <div class="movie-card">
        <img src="../server/images/${movie.image}" alt="${movie.name}" />
        <h3>${movie.name}</h3>
      </div>
    `;
  }).join('');
  
  return moviesHTML;
};
```

---

## 🗂️ Détail des fichiers clés

### Backend (PHP)

| Fichier | Rôle |
|---------|------|
| `script.php` | Point d'entrée, routeur des requêtes |
| `controller.php` | Traite les requêtes HTTP |
| `model.php` | Accès à la BD, requêtes SQL |

### Frontend (JavaScript)

| Fichier | Rôle |
|---------|------|
| `app/index.html` | Page principale, démarre l'app |
| `app/data/dataMovie.js` | Module pour requêter le serveur |
| `app/component/Movie/script.js` | Composant pour afficher les films |
| `app/component/NavBar/script.js` | Composant pour la navbar |

---

## 🚀 Concepts importants

### 1. **Async/Await** en JavaScript
```javascript
// Attendre la réponse du serveur
let answer = await fetch(URL);
let data = await answer.json();
```

### 2. **Fetch API** pour requêtes HTTP
```javascript
// Faire une requête GET
fetch("/server/script.php?todo=readmovies")
```

### 3. **PDO** pour accès à la BD en PHP
```php
// Préparation sécurisée des requêtes
$stmt = $cnx->prepare("SELECT ... FROM ...");
$stmt->execute();
```

### 4. **JSON** pour l'échange de données
- Le serveur retourne du JSON
- Le JavaScript parse le JSON avec `.json()`

### 5. **Composants modulaires**
- Chaque composant gère son propre HTML
- Réutilisable et maintenable

---

## 📌 À retenir

1. **L'architecture MVC sépare les responsabilités:**
   - Modèle = Données
   - Contrôleur = Logique
   - Vue = Affichage

2. **Le flux est toujours le même:**
   Frontend → Serveur → Base de données → Serveur → Frontend

3. **Chaque fichier a une responsabilité unique:**
   - Facile à comprendre et modifier

---

## 🔗 Ressources

- [MDN - async/await](https://developer.mozilla.org/fr/docs/Web/JavaScript/Reference/Statements/async_function)
- [MDN - Fetch API](https://developer.mozilla.org/fr/docs/Web/API/Fetch_API)
- [PHP - PDO](https://www.php.net/manual/fr/class.pdo.php)
