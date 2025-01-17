<?php
require_once(__DIR__ . '/../config/autoload.php');
require_once(__DIR__ . '/../config/init.php');

class ModifyApporteurController extends AbstractController
{
    private $title;

    public function __construct()
    {
        $this->title = 'Modifier un code apporteur';
        parent::__construct(); 
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->handleGetRequest();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest();
        } else {
            throw new Exception("Méthode non autorisée");
        }
    }

    public function handleGetRequest()
    {
        $idApporteur = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

        if ($idApporteur === 0) {
            throw new Exception("Code apporteur invalide ou manquant.");
        } else {
            $apporteur = ApporteurManager::getApporteurById($idApporteur);
           
            if (!$apporteur) {
                throw new Exception("Aucun apporteur trouvé avec l'ID : " . $idApporteur);
            }
        }

        $this->renderView(compact('apporteur'));
    }

    private function handlePostRequest()
    {
        $idApporteur = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

        $errors = [];
        $msg = '';

        // Form inputs
        $codeApporteur = filter_input(INPUT_POST, 'code_apporteur', FILTER_SANITIZE_SPECIAL_CHARS);
        $nomApporteur = filter_input(INPUT_POST, 'nom_apporteur', FILTER_SANITIZE_SPECIAL_CHARS);

        // Validate inputs
        if (empty($nomApporteur)) {
            $errors['nom_apporteur'] = 'Le nom d\'apporteur est obligatoire.';
        }


        if (empty($codeApporteur)) {
            $errors['code_apporteur'] = 'Le code apporteur est obligatoire.';
        } else {
          
            $isOk = filter_var($codeApporteur, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXCODE . '/')));
           
            if (!$isOk) {
                $errors['code_apporteur'] = 'Le code d\'apporteur doit composer de chiffre ou de lettre sans espace';
            } else {
                if (ApporteurManager::isExistCodeApporteur($codeApporteur) &&
                $nomApporteur === ApporteurManager::isExistNomApporteur($nomApporteur)) {
                    $errors['code_apporteur'] = 'Ce code apporteur existe déjà.';
                }
            }
        }
        
    

        if (empty($errors)) {
            
            $updatedApporteur = new Apporteur();
            $updatedApporteur->setIdApporteur($idApporteur);
            $updatedApporteur->setCode_Apporteur($codeApporteur);
            $updatedApporteur->setNom_Apporteur($nomApporteur);
             
            $updatedResult = ApporteurManager::updatedApporteur($updatedApporteur);

            if ($updatedResult) {
                $msg = 'L\'apporteur a bien été modifié avec succès.';
                $_SESSION['msg'] = $msg;

                $logManager = new LogManager();
                $logManager->logModifyCode($codeApporteur, $_SESSION['username']);

                header('Location:'.$_ENV['URL_PROD'].'/controllers/ListApporteurController.php');
                exit;
            } else {
                $msg = 'Erreur, la modification n\'a pas été bien prise en compte.';
            }

            $this->renderView(compact('msg', 'errors'));

        } else {
            
            $apporteur = ApporteurManager::getApporteurById($idApporteur);
            $this->renderView(compact('apporteur', 'errors'));
        }
        
       
    }

    private function renderView($data)
    {
        extract($data);
        $modifyApporteurController = $this;
        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/modifyApporteur.php';
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
    $modifyApporteurController = new ModifyApporteurController();
    $modifyApporteurController->handleRequest();
} catch (\Throwable $th) {
    include __DIR__ . '/../views/templates/header.php';
    include __DIR__ . '/../views/templates/error.php';
    include __DIR__ . '/../views/templates/footer.php';
}