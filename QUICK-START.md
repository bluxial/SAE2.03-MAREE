# Quick Start - Comprendre le projet en 5 minutes

## 🎯 L'objectif

Afficher une **liste de films** depuis une **base de données** sur une page web.

---

## 📍 Les 3 endroits clés

### 1️⃣ Frontend - app/index.html
```javascript
// Récupérer les films
let movies = await DataMovie.requestMovies();

// Les afficher
Movie.format(movies);
```

### 2️⃣ Backend - server/script.php + controller.php + model.php
```php
// Récupérer les films de la BDD
SELECT id, name, image FROM SAE203_Movie;

// Les retourner en JSON
json_encode($movies);
```

### 3️⃣ Base de données - maree2
```
Table SAE203_Movie:
id | name                | image            
1  | Interstellar        | interstellar.jpg
2  | La Liste de Schindler| schindler.webp
...
```

---

## 🔄 Le flux simplifié

```
1. Page charge          → app/index.html
2. JS requête serveur   → DataMovie.requestMovies()
3. Serveur requête BDD  → model.php
4. BDD retourne films   → JSON
5. JS affiche films     → Movie.format()
```

---

## 🧪 Tester en 3 étapes

### Étape 1: Vérifier que le serveur fonctionne
```
https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/server/script.php?todo=readmovies
```
Vous devez voir du **JSON** avec les films.

### Étape 2: Vérifier que la page s'affiche
```
https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/app/index.html
```
Vous devez voir des **cartes de films**.

### Étape 3: Vérifier qu'il n'y a pas d'erreurs
Appuyez sur **F12** (Console) - vous ne devez voir **AUCUNE erreur rouge**.

---

## 📚 Les 3 fichiers à comprendre

### app/data/dataMovie.js
```javascript
// Ce fichier demande les films au serveur
DataMovie.requestMovies = async function() {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
  return await answer.json();
}
```
**À retenir:** Fait la requête HTTP au serveur.

### server/model.php
```php
// Ce fichier accède à la base de données
function getAllMovies() {
  $sql = "SELECT id, name, image FROM SAE203_Movie";
  return $cnx->query($sql);
}
```
**À retenir:** Récupère les films de la BDD.

### app/component/Movie/script.js
```javascript
// Ce fichier crée le HTML des films
Movie.format = function(movies) {
  return movies.map(m => `
    <div class="movie-card">
      <img src="../server/images/${m.image}" />
      <h3>${m.name}</h3>
    </div>
  `).join('');
}
```
**À retenir:** Génère le HTML pour afficher les films.

---

## 🎓 Comment expliquer le projet

### À quelqu'un qui ne connaît rien:
> "C'est une application qui permet d'afficher les films d'une base de données. Quand vous chargez la page, JavaScript demande les films au serveur. Le serveur va chercher les films dans la BDD et les renvoie. Ensuite, JavaScript formate les films en cartes et les affiche sur la page."

### À quelqu'un qui comprend le web:
> "C'est une architecture MVC simple. Le modèle (model.php) accède à la BDD. Le contrôleur (controller.php) traite les requêtes. La vue (composant Movie) génère le HTML. Les données passent en JSON entre le front et le back."

### À un prof (détaillé):
> "L'application utilise une architecture MVC avec séparation frontend/backend. Le frontend (app/) utilise des modules JavaScript ES6 et des composants réutilisables. Chaque requête passe par le routeur (script.php) qui dirige vers le bon contrôleur. Le modèle utilise PDO pour accéder de manière sécurisée à la base de données. Les réponses sont sérialisées en JSON et traitées avec async/await en frontend."

---

## 💻 En cas de problème

### Erreur dans la console
👉 Ouvrez F12 → Console → Lisez le message d'erreur

### Les films ne s'affichent pas
👉 Testez l'URL du serveur: `script.php?todo=readmovies`

### Les images ne s'affichent pas
👉 Vérifiez que `/server/images/` existe et contient les images

### "Cannot read property 'map'"
👉 Les films n'ont pas été récupérés → Vérifiez le serveur PHP

---

## ✅ Validation

Vous avez compris si vous pouvez:

- [ ] Expliquer le flux données → serveur → affichage
- [ ] Identifier où se fait la requête HTTP
- [ ] Identifier où se fait l'accès à la BDD
- [ ] Identifier où se fait l'affichage
- [ ] Lire et modifier la requête SQL
- [ ] Lire et modifier le code JavaScript
- [ ] Tester votre application et débugguer

---

## 🚀 Prochaines étapes

Une fois que vous maîtrisez ça:

1. **Ajouter les catégories** → JOIN avec SAE203_Category
2. **Filtrer par catégorie** → Passer un paramètre au serveur
3. **Ajouter des détails** → Récupérer plus de colonnes
4. **Page de détails d'un film** → Créer une nouvelle page
5. **Admin** → Ajouter/modifier/supprimer des films

---

## 📖 Documentation complète

- [ARCHITECTURE-PEDAGOGIQUE.md](./ARCHITECTURE-PEDAGOGIQUE.md) - Vue d'ensemble détaillée
- [GUIDE-COMPOSANTS.md](./GUIDE-COMPOSANTS.md) - Comment créer un composant
- [GUIDE-CATEGORIES.md](./GUIDE-CATEGORIES.md) - Ajouter les catégories
- [GUIDE-TEST.md](./GUIDE-TEST.md) - Comment tester et dépanner
