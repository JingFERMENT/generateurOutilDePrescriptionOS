<?php
require_once(__DIR__.'/../config/autoload.php');

class ListCampagneController {

    public function index (){

        session_start();

        $title = 'Liste des codes campagnes';
        
        Auth::verifyIsConnected();
        
        // Handle session message if available
        if(isset($_SESSION['msg']) ){
            $msg = $_SESSION['msg'];
            unset($_SESSION['msg']);
        } 

        // Retrieve all campagne codes
        $campagnes = CampagneManager::getAllCodesCampagne();

        $apporteursArrayForEachCampagne = [];

        foreach ($campagnes as $campagne) {
            $id_campagne = $campagne->id_campagne;
        
            $apporteurs = CampagneManager::getAllCodesApporteurByCodeCampagne($id_campagne);
            
            $apporteursArrayForEachCampagne[$id_campagne] = $apporteurs;   
        }

        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/listCampagne.php';
        include __DIR__ . '/../views/templates/footer.php';
    }
}

try {
    $listCampagneController = new ListCampagneController();
    $listCampagneController->index();
} catch (\Throwable $th) {
    echo "An error occurred: " . $th->getMessage();
}