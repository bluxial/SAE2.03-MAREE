<?php

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


        default: // il y a un paramètre todo mais sa valeur n'est pas reconnue/supportée
            echo json_encode('[error] Unknown todo value');
            http_response_code(400); // 400 == "Bad request"
            exit();
    }

    if ($data === false) {
        echo json_encode('[error] Controller returns false');
        http_response_code(500); // 500 == "Internal error"
        exit();
    }

    echo json_encode($data);
    http_response_code(200); // 200 == "OK"
    exit();


}


http_response_code(404); // 404 == "Not found"



?>