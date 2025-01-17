<?php
require_once(__DIR__.'/../config/autoload.php');
require_once(__DIR__ . '/../config/init.php');

class AddCampagneController extends AbstractController{

    private $title;
    private $errors = [];
    private $msg = '';
    private $codesApporteurs = [];

    public function __construct()
    {
        parent::__construct();
        $this->title = 'Ajouter un code campagne';
        $this->codesApporteurs = ApporteurManager::getAllCodesApporteur();
    }

    public function handleRequest()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processForm();
        } 

        $allApporteurs = CampagneManager::getAllCodesApporteurs();
        $this->renderView(['allApporteurs' => $allApporteurs]);
        
    }

    private function processForm()
    {
        $codeCampagne = filter_input(INPUT_POST, 'code_campagne', FILTER_SANITIZE_SPECIAL_CHARS);
        $nomCampagne = filter_input(INPUT_POST, 'nom_campagne', FILTER_SANITIZE_SPECIAL_CHARS);
        $codesApporteurs = filter_input(INPUT_POST, 'codes_apporteurs', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);


        $this->validateForm($codeCampagne, $nomCampagne, $codesApporteurs);

        if (empty($this->errors)) {
            $this->addCampagne($codeCampagne, $nomCampagne, $codesApporteurs);
        }
    }

    private function validateForm($codeCampagne, $nomCampagne, $codesApporteurs)
    {
        $isExistDuplicate = CampagneManager::isExist($codeCampagne);
        if (empty($codeCampagne)) {
            $this->errors['code_campagne'] = 'Le code de campagne est obligatoire.';
        } else {
            $isOk = filter_var($codeCampagne, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXCODE . '/')));
            if (!$isOk) {
                $this->errors['code_campagne'] = 'Le code de campagne doit composer de chiffre ou de lettre sans espace';
            } else {
                if ($isExistDuplicate) {
                    $this->errors['code_campagne'] = 'Ce code de campagne existe déjà.';
                }
            }
        }
        

        if (empty($nomCampagne)) {
            $this->errors['nom_campagne'] = 'Le nom de campagne est obligatoire.';
        }

        if (!empty($codesApporteurs)) {
            $codesApporteursArray = ApporteurManager::getAllCodesApporteur();
            foreach ($codesApporteurs as $codeApporteur) {
                if (!in_array($codeApporteur, $codesApporteursArray)) {
                    $error['code_apporteur'] = 'Votre choix est invalide';
                }
            }
        }
    }

    private function addCampagne($codeCampagne, $nomCampagne, $codesApporteurs)
    {
        $campagne = new Campagne();
        $campagne->setCode_campagne($codeCampagne);
        $campagne->setNom_campagne($nomCampagne);

        $addCodeCampagne = CampagneManager::addCodeCampagne($campagne, $codesApporteurs);

        if ($addCodeCampagne) {
            $logManager = new LogManager();
            $logManager->logAddCode($codeCampagne, $_SESSION['username']);
            $this->msg = 'La campagne a bien été ajoutée avec succès.';
            $_SESSION['msg'] = $this->msg;
            header('Location:'.$_ENV['URL_PROD'].'/controllers/ListCampagneController.php');
            die;
        } else {
            $this->msg = 'Erreur, la campagne n\'a pas été ajoutée. Veuillez réessayer.';
        }
    }

    private function renderView($data)
    {
        extract($data);
        $addCampagneController = $this;
        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/addCampagne.php';
        include __DIR__ . '/../views/templates/footer.php';
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function getCodesApporteurs()
    {
        return $this->codesApporteurs;
    }
}

// Instantiate and handle the request
try {
    $addCampagneController = new AddCampagneController();
    $addCampagneController->handleRequest();
} catch (\Throwable $th) {
    echo "An error occurred: " . $th->getMessage();
}
