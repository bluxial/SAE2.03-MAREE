# Comment utiliser les catégories

## 📌 État actuel

Vous avez actuellement:
- ✅ Les **films** qui s'affichent
- ✅ La table **SAE203_Movie** avec des films
- ✅ La table **SAE203_Category** avec les catégories
- ❌ Les catégories ne sont **pas affichées** pour l'instant

---

## 🚀 Ajouter les catégories

### Étape 1: Modifier la requête SQL dans model.php

**Avant** (actuellement):
```php
$sql = "SELECT id, name, image FROM SAE203_Movie";
```

**Après** (pour inclure les catégories):
```php
$sql = "SELECT 
    m.id, 
    m.name, 
    m.image,
    c.name as category
FROM SAE203_Movie m
LEFT JOIN SAE203_Category c ON m.id_category = c.id";
```

### Étape 2: Modifier le composant Movie pour afficher la catégorie

**Dans app/component/Movie/script.js**:

Remplacer:
```javascript
<h3 class="movie-card__title">${movie.name}</h3>
```

Par:
```javascript
<h3 class="movie-card__title">${movie.name}</h3>
<p class="movie-card__category">${movie.category || 'Sans catégorie'}</p>
```

### Étape 3: Ajouter le style dans Movie/style.css

```css
.movie-card__category {
  padding: 0.5rem 1rem;
  color: #666;
  font-size: 0.9rem;
  text-align: center;
  margin: 0;
}
```

---

## 📊 Comprendre la jointure

### Schéma des tables:

**SAE203_Movie:**
```
id | name              | image           | id_category
1  | Interstellar      | interstellar.jpg | 4
2  | La Liste...       | schindler.webp  | 3
3  | Your Name         | your_name.jpg   | 5
```

**SAE203_Category:**
```
id | name
1  | Action
2  | Comédie
3  | Drame
4  | Science-fiction
5  | Animation
```

### La requête JOIN:

```sql
SELECT m.*, c.name as category
FROM SAE203_Movie m
LEFT JOIN SAE203_Category c ON m.id_category = c.id
```

**Résultat:**
```
id | name              | image           | id_category | category
1  | Interstellar      | interstellar.jpg | 4           | Science-fiction
2  | La Liste...       | schindler.webp  | 3           | Drame
3  | Your Name         | your_name.jpg   | 5           | Animation
```

Les données du film **sont jointes** avec le nom de sa catégorie!

---

## 🎬 Affichage final

Après les modifications, chaque film affichera:

```
┌─────────────────────────┐
│    [Image du film]      │
├─────────────────────────┤
│   Interstellar          │
│   Science-fiction       │
└─────────────────────────┘
```

---

## 🔍 Vérifier que ça fonctionne

### 1. Tester la requête SQL

Sur phpMyAdmin ou en terminal MySQL:
```sql
SELECT 
    m.id, 
    m.name, 
    m.image,
    c.name as category
FROM SAE203_Movie m
LEFT JOIN SAE203_Category c ON m.id_category = c.id;
```

**Vous devez voir** les films avec leurs catégories.

### 2. Tester le serveur PHP

Allez sur:
```
https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/server/script.php?todo=readmovies
```

**Vous devez voir** du JSON avec la clé `"category"` pour chaque film.

### 3. Tester dans le navigateur

Allez sur:
```
https://mmi.unilim.fr/~maree2/SAE2.03-MAREE/app/index.html
```

**Vous devez voir** les catégories sous chaque titre de film.

---

## 💡 Concepts importants

### **LEFT JOIN** vs **INNER JOIN**

```sql
-- LEFT JOIN: Tous les films, même sans catégorie
SELECT m.*, c.name as category
FROM SAE203_Movie m
LEFT JOIN SAE203_Category c ON m.id_category = c.id;

-- INNER JOIN: Seulement les films avec catégorie
SELECT m.*, c.name as category
FROM SAE203_Movie m
INNER JOIN SAE203_Category c ON m.id_category = c.id;
```

Utilisez **LEFT JOIN** pour ne perdre aucun film.

### **Alias** (`as category`)

```sql
c.name as category  -- Renomme la colonne c.name en "category"
```

Utile pour éviter les conflits de noms et rendre le code lisible.

---

## 🐛 Dépannage

### Je ne vois pas les catégories

1. **Vérifiez que la requête SQL fonctionne:**
   ```sql
   SELECT m.id, m.name, c.name as category
   FROM SAE203_Movie m
   LEFT JOIN SAE203_Category c ON m.id_category = c.id;
   ```

2. **Vérifiez que la colonne `id_category` existe:**
   ```sql
   DESCRIBE SAE203_Movie;  -- Voir toutes les colonnes
   ```

3. **Vérifiez que le JSON inclut `"category"`:**
   - Allez sur `script.php?todo=readmovies`
   - Vérifiez que vous voyez `"category": "..."` dans le JSON

4. **Vérifiez que le HTML inclut la catégorie:**
   - F12 → Éléments
   - Cherchez `<p class="movie-card__category">`

### Toutes les catégories affichent "Sans catégorie"

- La colonne `id_category` dans les films est `NULL`
- Remplissez la colonne `id_category` pour les films

---

## ✅ Avant de continuer

Vérifiez que:
1. ✅ Les films s'affichent toujours
2. ✅ Les catégories s'affichent à côté
3. ✅ Aucune erreur dans la console (F12)
4. ✅ Vous comprenez la requête SQL JOIN

---

## 🎯 Prochaines étapes

Une fois les catégories affichées:
- Ajouter un **filtre par catégorie**
- Ajouter des **détails** sur les films (description, année, etc.)
- **Trier** les films par catégorie
