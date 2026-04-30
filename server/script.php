<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

ob_start();

set_exception_handler(function ($e) {
    ob_end_clean();
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    exit();
});
error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require("controller.php");


if (isset($_REQUEST['todo'])) {

    header('Content-Type: application/json');

    $todo = $_REQUEST['todo'];

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
            http_response_code(400); // 400 == "Bad request"
            echo json_encode('[error] Unknown todo value');
            exit();
    }

    if ($data === false) {
        http_response_code(500); // 500 == "Internal error"
        echo json_encode('[error] Controller returns false');
        exit();
    }

    http_response_code(200); // 200 == "OK"
    echo json_encode($data);
    exit();


}


http_response_code(404); // 404 == "Not found"



?>