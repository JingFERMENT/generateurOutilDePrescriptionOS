<?php
require_once(__DIR__ . '/../config/autoload.php');

class FormController extends AbstractController
{
    private $title = 'Formulaire';
    private $campagnes;
    private $msg;

    public function __construct()
    {
        parent::__construct();
        $this->title = 'Formulaire';
        $this->campagnes = CampagneManager::getAllCodesCampagne();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->handleGetRequest();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handlePostRequest();
        } else {
            throw new Exception('Méthode non autorisée');
        }
    }

    private function handleGetRequest()
    {
        $idCampagne = intval(filter_input(INPUT_GET, 'id_campagne', FILTER_SANITIZE_NUMBER_INT));

        if ($idCampagne !== 0) {
            try {
                $apporteurs = CampagneManager::getAllApporteurByCodeCampagne($idCampagne);
                echo json_encode($apporteurs);
                exit;
            } catch (Exception $error) {
                echo json_encode(['error' => $error->getMessage()]);
                exit;
            }
        } else {
            $campagnes = CampagneManager::getAllCodesCampagne();
            $this->renderView(['campagnes' => $campagnes, 'idCampagne' => $idCampagne]);
        }
    }

    private function handlePostRequest()
    {
        $errors = [];

        $idPart = $this->validateIdPart(
            filter_input(INPUT_POST, 'id_part', FILTER_SANITIZE_SPECIAL_CHARS),
            $errors
        );

        $idCampagne = $this->validateIdCampagne(
            filter_input(INPUT_POST, 'id_campagne', FILTER_SANITIZE_SPECIAL_CHARS),
            $errors
        );

        $codeApporteur = $this->validateCodeApporteur(
            filter_input(INPUT_POST, 'code_apporteur', FILTER_SANITIZE_SPECIAL_CHARS),
            $idCampagne,
            $errors
        );

        $infos = $this->validateInfos(
            filter_input(INPUT_POST, 'infos', FILTER_SANITIZE_SPECIAL_CHARS),
            $errors
        );

        if (empty($errors)) {
            $this->processFormSubmission($idPart, $idCampagne, $codeApporteur, $infos);
        }

        $this->renderView([
            'errors' => $errors,
            'msg' => $this->msg,
            'id_part' => $idPart ?? '',
            'id_campagne' => $idCampagne ?? '',
            'code_apporteur' => $codeApporteur ?? '',
            'infos' => $infos ?? '',
            'retour' => $this->retour ?? '',
        ]);
    }

    private function validateIdPart($idPart, &$errors)
    {

        if (empty($idPart)) {
            $errors['id_part'] = 'Ce champ est obligatoire';
        } else {
            if (!is_numeric($idPart)) {
                $errors['id_part'] = 'L\'identifiant partenaire doit se composer de 14 chiffres.';
            } else {
                $isOk = filter_var($idPart, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXIDPART . '/')));
                if (!$isOk) {
                    $errors['id_part'] = 'L\'identifiant partenaire doit se composer de 14 chiffres.';
                }
            }
        }

        return $idPart;
    }

    /**
     * Validate the id campagne
     * 
     * @return int|null the campagne ID
     */
    private function validateIdCampagne($idCampagne, &$errors)
    {
        $idCampagne = intval($idCampagne);
        if (empty($idCampagne)) {
            $errors['nom_campagne'] = 'Ce champ est obligatoire';
        } else if (!CampagneManager::isExistIdCampagne($idCampagne)) {
            $errors['nom_campagne'] = 'Votre choix est invalide';
        } else {
            $campagne = CampagneManager::getCodeCampagneById($idCampagne);
            return $campagne->getCode_Campagne();
        }
        return null;
    }

    private function validateCodeApporteur($codeApporteur, $idCampagne, &$errors)
    {

        $apporteurs = CampagneManager::getAllApporteurByCodeCampagne($idCampagne);

        if (empty($codeApporteur) && count($apporteurs) > 1) {
            $errors['code_apporteur'] = 'Veuillez sélectionner un apporteur';
        }

        return $codeApporteur;
    }

    private function validateInfos($infos, &$errors)
    {
        if ($infos && strlen($infos) > 1000) {
            $errors['infos'] = 'Merci de ne pas dépasser 1000 mots.';
        }
        return $infos;
    }

    private function processFormSubmission($idPart, $codeCampagne, $codeApporteur, $infos)
    {
        $leadData = new LeadData();
        $leadData->id_part = $idPart;
        $leadData->code_apporteur = $codeApporteur;
        $leadData->code_campagne = $codeCampagne;
        $leadData->infos['Commentaire'] = $infos;
        $leadData->infos['Soumis par'] = $_SESSION['username'];

        $leadData->matricule = $_SESSION['username'];

        if (LeadDataManager::send($leadData)) {
            $this->msg = "Votre demande a bien été prise en compte.";

            $_SESSION['msg'] = $this->msg;

            $logManager = new LogManager();
            $recipient = $_ENV['recipient'];
            $logManager->logMailSent($recipient, $_SESSION['username']);
        } else {
            $errors['mail'] = "Échec de l'envoi de l'email.";
        }

        header('Location:' . $_ENV['URL_PROD'] . 'form');
        die;
    }

    private function renderView(array $data = [])
    {
        extract($data);
        $formController = $this;

        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/form.php';
        include __DIR__ . '/../views/templates/footer.php';
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the value of campagnes
     */
    public function getCampagnes()
    {
        return $this->campagnes;
    }
}

try {
    $formController = new FormController();
    $formController->handleRequest();
} catch (\Throwable $th) {
    echo "An error occurred: " . $th->getMessage();
}
