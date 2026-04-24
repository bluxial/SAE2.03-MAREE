<?php
// Activer le rapport d'erreurs PHP
error_reporting(E_ALL);

// Ne PAS afficher les erreurs à l'écran (elles corrompraient le JSON)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Envoyer les erreurs dans le fichier log
ini_set('log_errors', 1);

require("controller.php");

if (isset($_REQUEST['todo'])) {

    header('Content-Type: application/json');

    $todo = $_REQUEST['todo'];

    switch ($todo) {


        case 'readmovies':
            $data = readMoviesController();
            break;

        case 'addmovie':
            $data = addMovieController();
            break;

        case 'readcategories':
            $data = readCategoriesController();
            break;

        default:
            echo json_encode('[error] Unknown todo value');
            http_response_code(400);
            exit();
    }

    if ($data === false) {
        echo json_encode('[error] Controller returns false');
        http_response_code(500);
        exit();
    }

    echo json_encode($data);
    http_response_code(200);
    exit();
}

http_response_code(404);
?>