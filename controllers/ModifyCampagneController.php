<?php
require_once(__DIR__.'/../config/autoload.php');
require_once(__DIR__ . '/../config/init.php');

class ModifyCampagneController extends AbstractController {
    private $title;

    public function __construct() {
        
        $this->title = 'Modifier un code campagne';
        parent::__construct(); 
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->handleGetRequest();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest();
        } else {
            throw new Exception("Méthode non autorisée");
        }
    }

    public function handleGetRequest() {
        $idCampagne = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

        if ($idCampagne === 0) {
            throw new Exception("Code campagne invalide ou manquant.");
        }

        $campagne = CampagneManager::getCodeCampagneById($idCampagne);

        if (!$campagne) {
            throw new Exception("Aucune campagne trouvée avec l'ID : " . $idCampagne);
        }

        $allApporteurs = CampagneManager::getAllCodesApporteurs();
        $apporteursByCodeCampagne = CampagneManager::getAllCodesApporteurByCodeCampagne($idCampagne);

        $this->renderView(compact('campagne', 'allApporteurs', 'apporteursByCodeCampagne'));
    }

    private function handlePostRequest() {

        $idCampagne = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
        $errors = [];
        $msg = '';

        // Code campagne
        $codeCampagne = filter_input(INPUT_POST, 'code_campagne', FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$codeCampagne) {
            $errors['code_campagne'] = 'Le code campagne est obligatoire.';
        } else {
          
            $isOk = filter_var($codeCampagne, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXCODE . '/')));
           
            if (!$isOk) {
                $errors['code_campagne'] = 'Le code de campagne doit composer de chiffre ou de lettre sans espace';
            } 
        }



        // Nom campagne
        $nomCampagne = filter_input(INPUT_POST, 'nom_campagne', FILTER_SANITIZE_SPECIAL_CHARS);
        if (!$nomCampagne) {
            $errors['nom_campagne'] = 'Le nom de campagne est obligatoire.';
        }

        // Apporteurs
        $codeApporteurs = filter_input(INPUT_POST, 'apporteurs', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

        $idApporteursArray = [];

        if(!empty($codeApporteurs)){
            foreach ($codeApporteurs as $key => $codeApporteur) {
                $idApporteur = ApporteurManager::getIdApporteur($codeApporteur);
                $idApporteursArray[$key] = $idApporteur;
            }
        }

        if (empty($errors)) {
            $updatedCampagne = new Campagne();
            $updatedCampagne->setIdCampagne($idCampagne);
            $updatedCampagne->setCode_campagne($codeCampagne);
            $updatedCampagne->setNom_campagne($nomCampagne);

            $updatedCampagneManager = new CampagneManager();
            $updatedResult = $updatedCampagneManager->updateCodeCampagne($updatedCampagne, $idApporteursArray);

            if ($updatedResult) {
                $msg = 'La campagne a bien été modifiée avec succès.';
                $_SESSION['msg'] = $msg;

                $logManager = new LogManager();
                $logManager->logModifyCode($codeCampagne, $_SESSION['username']);

                header('Location:'.$_ENV['URL_PROD'].'/controllers/ListCampagneController.php');
                exit;
            } else {
                $msg = 'Erreur, la modification n\'a pas été bien prise en compte.';
                $_SESSION['msg'] = $msg;
            }

            // Re-fetch the campaign in case of errors to show form again
            $campagne = CampagneManager::getCodeCampagneById($idCampagne);
            $this->renderView(compact('msg', 'errors', 'campagne'));
        } else {
            $campagne = CampagneManager::getCodeCampagneById($idCampagne);
            $allApporteurs = CampagneManager::getAllCodesApporteurs();
            $apporteursByCodeCampagne = CampagneManager::getAllCodesApporteurByCodeCampagne($idCampagne);
            $this->renderView(compact('errors', 'campagne', 'allApporteurs', 'apporteursByCodeCampagne'));
        }
    }

    private function renderView($data) {
        extract($data);
        $modifyCampagneController = $this;
        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/modifyCampagne.php';
        include __DIR__ . '/../views/templates/footer.php';
    }

     /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }
}

try {
    $modifyCampagneController = new ModifyCampagneController();
    $modifyCampagneController->handleRequest();
} catch (\Throwable $th) {
    include __DIR__ . '/../views/templates/header.php';
    include __DIR__ . '/../views/templates/error.php';
    include __DIR__ . '/../views/templates/footer.php';
}
