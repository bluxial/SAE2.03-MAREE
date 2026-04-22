<?php
// ============================================================
// SCRIPT.PHP - Point d'entrée des requêtes HTTP
// ============================================================
// Ce fichier reçoit TOUTES les requêtes HTTP.
// Il dirige les requêtes vers le bon contrôleur selon le paramètre "todo".
// ============================================================

// Inclure le contrôleur pour accéder aux fonctions de traitement
require("controller.php");

// Vérifier si la requête contient le paramètre 'todo'
if ( isset($_REQUEST['todo']) ){
  // Indiquer au client que la réponse sera en JSON
  header('Content-Type: application/json');

  // Récupérer la valeur du paramètre 'todo'
  $todo = $_REQUEST['todo'];

  // Appeler la bonne fonction selon le paramètre 'todo'
  switch($todo){

    case 'readmovies':
      // Appeler le contrôleur pour récupérer les films
      $data = readMoviesController();
      break;

    default:
      // La valeur de 'todo' n'est pas reconnue
      echo json_encode(array('error' => 'Action inconnue'));
      http_response_code(400);
      exit();
  }

  // Vérifier si le contrôleur a retourné une erreur
  if ($data === false){
    echo json_encode(array('error' => 'Erreur serveur'));
    http_response_code(500);
    exit();
  }

  // Tout s'est bien passé : retourner les données en JSON
  echo json_encode($data);
  http_response_code(200);
  exit();
}

// Si 'todo' n'est pas défini, retourner une erreur 404
http_response_code(404);
?>