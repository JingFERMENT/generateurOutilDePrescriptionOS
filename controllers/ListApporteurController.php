<?php
require_once(__DIR__.'/../config/autoload.php');

class ListApporteurController {

    public function index (){

        session_start();

        $title = 'Liste des codes des apporteurs';
        
        Auth::verifyIsConnected();
        
        // Handle session message if available
        if(isset($_SESSION['msg']) ){
            $msg = $_SESSION['msg'];
            unset($_SESSION['msg']);
        } 

        // Retrieve all apporteur codes
        $apporteurs = ApporteurManager::getAllCodesApporteur();

        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/listApporteur.php';
        include __DIR__ . '/../views/templates/footer.php';
    }

}

try {
    $listApporteurController = new ListApporteurController();
    $listApporteurController->index();
} catch (\Throwable $th) {
    echo "Une erreur est survenue: " . $th->getMessage();
}
