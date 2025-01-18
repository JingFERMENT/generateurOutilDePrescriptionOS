<?php 

require_once(__DIR__ . '/config/autoload.php');

// Retrieve the URL requested by the user
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Create an instance of the Router
$router = new Router();

// Define routes
$router->addRoute('/' ,'controllers/SignupController.php');
$router->addRoute('/logout' ,'controllers/LogOutController.php');

$router->addRoute('/listCampagne' ,'controllers/ListCampagneController.php');
$router->addRoute('/listApporteur' ,'controllers/ListApporteurController.php');

$router->addRoute('/addApporteur' ,'controllers/AddApporteurController.php');
$router->addRoute('/addCampagne' ,'controllers/AddCampagneController.php');

$router->addRoute('/modifyApporteur' ,'controllers/ModifyApporteurController.php');
$router->addRoute('//modifyCampagne' ,'controllers/ModifyCampagneController.php');

$router->addRoute('/deleteCampagne' ,'controllers/DeleteCampagneController.php');
$router->addRoute('/deleteApporteur' ,'controllers/DeleteApporteurController.php');

$router->addRoute('/form' ,'controllers/FormController.php');

// Dispatch the current URI
$router->dispatch($uri);