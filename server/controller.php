<?php
/** ARCHITECTURE PHP SERVEUR : Rôle du fichier controller.php
 *
 *  Ce fichier définit les fonctions de contrôle qui traitent les requêtes HTTP.
 *  Chaque fonction correspond à une valeur du paramètre 'todo' (voir script.php).
 *
 *  Si la fonction échoue, elle retourne false.
 *  Sinon, elle retourne les données à inclure dans la réponse HTTP.
 */

require("model.php");

function readMoviesController()
{
    $movies = getAllMovies();
    return $movies;
}

/**
 * Récupère et valide les paramètres POST, puis appelle addMovie().
 */
function addMovieController()
{
    // --- Champs obligatoires ---
    $required = ['name', 'director', 'year', 'length', 'description', 'id_category', 'min_age'];

    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            http_response_code(400);
            echo json_encode('[error] Champ obligatoire manquant : ' . $field);
            exit();
        }
    }

    $year = intval($_POST['year']);
    $length = intval($_POST['length']);
    $id_cat = $_POST['id_category']; // Accepter le texte directement
    $min_age = intval($_POST['min_age']);

    if ($year < 1888 || $year > 2100) {
        http_response_code(400);
        echo json_encode('[error] Année de sortie invalide.');
        exit();
    }
    if ($length < 1) {
        http_response_code(400);
        echo json_encode('[error] Durée invalide.');
        exit();
    }
    if (empty($id_cat)) {
        http_response_code(400);
        echo json_encode('[error] Catégorie invalide.');
        exit();
    }

    $data = [
        'name' => trim($_POST['name']),
        'director' => trim($_POST['director']),
        'year' => $year,
        'length' => $length,
        'description' => trim($_POST['description']),
        'id_category' => $id_cat,
        'image' => isset($_POST['image']) ? trim($_POST['image']) : '',
        'trailer' => isset($_POST['trailer']) ? trim($_POST['trailer']) : '',
        'min_age' => $min_age,
    ];

    $success = addMovie($data);

    if (!$success) {
        return false;
    }

    return ['message' => 'Le film "' . $data['name'] . '" a été ajouté avec succès.'];
}

function readCategoriesController()
{
    $categories = getAllCategories();
    return $categories;
}
