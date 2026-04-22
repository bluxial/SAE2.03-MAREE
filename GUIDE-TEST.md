# Guide de test - SAE2.03 Itération 1

## ✅ Checklist avant de tester

1. **Base de données** - Vérifiez que:
   - La base de données `maree2` existe
   - Les tables `SAE203_Movie` et `SAE203_Category` existent
   - Il y a des films dans `SAE203_Movie`

2. **Images** - Vérifiez que:
   - Le dossier `/server/images/` existe
   - Les images des films y sont présentes
   - Les noms correspondent aux données de la BD

3. **URL du serveur** - Vérifiez que:
   - Vous êtes sur `https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/`
   - OU sur un serveur PHP local avec la même structure

---

## 🧪 Tests

### Test 1: Vérifier que le serveur PHP fonctionne
**Dans votre navigateur**, allez sur:
```
https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/server/script.php?todo=readmovies
```

**Vous devez voir:**
- Du JSON avec les films
- Exemple:
```json
[
  {"id":7,"name":"Interstellar","image":"interstellar.jpg"},
  {"id":12,"name":"La Liste de Schindler","image":"schindler.webp"},
  ...
]
```

**Si vous voyez du code PHP brut (`<?php`)**:
- Le serveur PHP n'exécute pas le code
- Utilisez un serveur PHP local ou testez sur mmi.unilim.fr

---

### Test 2: Ouvrir l'application
**Allez sur:**
```
https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/app/index.html
```

**Vous devez voir:**
✅ Une barre de navigation avec un bouton "About"
✅ Une grille de films avec:
  - L'image du film
  - Le titre du film

---

### Test 3: Vérifier la console (F12)
Appuyez sur **F12** puis l'onglet **Console**

**Vous ne devez voir AUCUNE erreur**

Si vous voyez des erreurs comme:
- `Failed to fetch` = Problème de requête HTTP
- `Unexpected token` = Problème de JSON
- `Cannot read properties` = Problème de données

---

## 🐛 Dépannage

### Les films ne s'affichent pas

1. **Ouvrez F12 (Console)**
2. **Regardez les erreurs**
3. **Si error = "Failed to fetch"**
   - Le serveur PHP n'est pas accessible
   - Vérifiez que vous êtes sur mmi.unilim.fr ou un serveur PHP

4. **Si error = "Unexpected token"**
   - Le serveur retourne du HTML au lieu de JSON
   - Vérifiez que script.php s'exécute
   - Vérifiez le header: `header('Content-Type: application/json');`

5. **Si aucun message d'erreur mais pas de films**
   - Vérifiez que la requête HTTP retourne des données
   - Allez sur: `https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/server/script.php?todo=readmovies`

### Les images ne s'affichent pas

1. **Vérifiez que `/server/images/` existe**
2. **Vérifiez que les images y sont**
3. **Vérifiez que les noms correspondent à la BD**
4. **Dans F12, allez dans Network**
5. **Rechargez la page**
6. **Cherchez les requêtes qui échouent (404)**
7. **Le chemin de l'image est faux si 404**

---

## 📝 Comment expliquer le code

### Le flux simplifié à retenir:

1. **On charge la page** → `app/index.html`
2. **JavaScript demande les films** → `DataMovie.requestMovies()`
3. **Le serveur PHP les récupère** → `script.php → controller.php → model.php`
4. **La BD retourne les films** → `SELECT FROM SAE203_Movie`
5. **On affiche les films** → Composant `Movie.format()`

### Les 3 fichiers clés à comprendre:

1. **app/data/dataMovie.js** - Fait la requête au serveur
2. **server/model.php** - Accède à la BD et retourne les films
3. **app/index.html** - Lance l'app et affiche les films

---

## ✨ Points clés pour expliquer

- **MVC**: Model (données) / Controller (logique) / View (affichage)
- **Requête HTTP**: JavaScript fetch vers le serveur PHP
- **JSON**: Format d'échange entre front et back
- **Async/Await**: Attendre la réponse du serveur sans bloquer
- **PDO**: Accès sécurisé à la base de données

---

## 🎯 Objectif validé si:

✅ L'app affiche la navbar
✅ L'app affiche les films sous forme de cartes
✅ Chaque carte a l'image et le titre du film
✅ Aucune erreur dans la console
✅ Vous pouvez expliquer le flux = données → serveur → affichage
