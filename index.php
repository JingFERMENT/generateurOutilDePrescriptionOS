<?php 

require_once(__DIR__ . '/config/autoload.php');

// Retrieve the URL requested by the user
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Handle the routes 
$routes = [
    '/' => 'controllers/SignupController.php',
    '/logout' => 'controllers/LogOutController.php',

    '/listCampagne' => 'controllers/ListCampagneController.php',
    '/listApporteur' => 'controllers/ListApporteurController.php',

    '/addApporteur' => 'controllers/AddApporteurController.php',
    '/addCampagne' => 'controllers/AddCampagneController.php',

    '/modifyApporteur' => 'controllers/ModifyApporteurController.php',
    '/modifyCampagne' => 'controllers/ModifyCampagneController.php',
    
    '/deleteCampagne' => 'controllers/DeleteCampagneController.php',
    '/deleteApporteur' => 'controllers/DeleteApporteurController.php',

    '/form' => 'controllers/FormController.php',
];

// Check if the URL matches a defined route
if (array_key_exists($uri, $routes)) {
    // Include the corresponding file
    include $routes[$uri];
} else {
    include 'views/templates/404.php';
}