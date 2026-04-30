<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require("controller.php");

// on vérifie qu'il y a bien un paramètre todo dans la requête
if (isset($_REQUEST['todo'])) {

    header('Content-Type: application/json');

    $todo = $_REQUEST['todo'];

    // on appelle le bon controller selon la valeur de todo
    switch ($todo) {

        case 'addmovie':
            $data = addMovieController();
            break;

        case 'addprofile':
            $data = addProfileController();
            break;

        case 'readprofiles':
            $data = readProfilesController();
            break;

        case 'saveprofile':
            $data = saveProfileController();
            break;

        case 'readmoviedetail':
            $data = readMovieDetailController();
            break;

        case 'readmovies':
            $data = readMoviesController();
            break;

        case 'readcategories':
            $data = readCategoriesController();
            break;

        case 'readmoviesgroupedbycategory':
            $data = readMoviesGroupedByCategoryController();
            break;

        case 'addfavorite':
            $data = addFavoriteController();
            break;

        case 'readfavorites':
            $data = readFavoritesController();
            break;

        default:
            http_response_code(400);
            echo json_encode('[error] Unknown todo value');
            exit();
    }

    if ($data === false) {
        http_response_code(500);
        echo json_encode('[error] Controller returns false');
        exit();
    }

    http_response_code(200);
    echo json_encode($data);
    exit();
}

http_response_code(404);

?>