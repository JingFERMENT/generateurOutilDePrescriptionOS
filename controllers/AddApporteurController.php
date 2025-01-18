<?php
require_once(__DIR__ . '/../config/autoload.php');
require_once(__DIR__ . '/../config/init.php');

class AddApporteurController extends AbstractController
{
    private string $title;
    private array $errors = [];
    private string $msg = '';

    public function __construct()
    {
        parent::__construct();
        $this->title = 'Ajouter un apporteur';
    }

    public function handleRequest()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->processForm();
        }

        $this->renderView();
    }

    // Process the form data
    private function processForm()
    {

        // Sanitize and retrieve the input data
        $codeApporteur = filter_input(INPUT_POST, 'code_apporteur', FILTER_SANITIZE_SPECIAL_CHARS);

        $nomApporteur = filter_input(INPUT_POST, 'nom_apporteur', FILTER_SANITIZE_SPECIAL_CHARS);

        $this->validateForm($codeApporteur, $nomApporteur);

        // If no errors, attempt to add the new apporteur
        if (empty($this->errors)) {
            $this->addApporteur($codeApporteur, $nomApporteur);
        }
    }

    // Validate the input data
    private function validateForm(string $codeApporteur, string $nomApporteur)
    {

        if (empty($codeApporteur)) {

            $this->errors['code_apporteur'] = 'Le code d\'apporteur est obligatoire.';
        } else {

            $isOk = filter_var($codeApporteur, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXCODE . '/')));
            if (!$isOk) {
                $this->errors['code_apporteur'] = 'Le code d\'apporteur doit composer de chiffre ou de lettre sans espace';
            } else {
                if (ApporteurManager::isExistCodeApporteur($codeApporteur)) {
                    $this->errors['code_apporteur'] = 'Ce code apporteur existe déjà.';
                }
            }
        }

        if (empty($nomApporteur)) {

            $this->errors['nom_apporteur'] = 'Le nom d\'apporteur est obligatoire.';
        }
    }

    // Add the new apporteur
    private function addApporteur($codeApporteur, $nomApporteur)
    {

        $apporteur = new Apporteur();

        $apporteur->setCode_apporteur($codeApporteur);
        $apporteur->setNom_apporteur($nomApporteur);

        $addCodeApporteur = ApporteurManager::addCodeApporteur($apporteur);

        // If the method returns "true", redirect to the list
        if ($addCodeApporteur) {

            $logManager = new LogManager();
            $logManager->logAddCode($codeApporteur, $_SESSION['username']);

            $this->msg = 'L\'apporteur a bien été ajouté avec succès.';
            $_SESSION['msg'] = $this->msg;

            header('Location:' . $_ENV['URL_PROD'] . 'listApporteur');
            die;
        } else {
            $this->msg = 'Erreur, l\'apporteur n\'a pas été ajoutée. Veuillez réessayer.';
        }
    }

    private function renderView()
    {
        $addApporteurController = $this; // Pass the current instance
        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/addApporteur.php';
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
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get the value of msg
     */
    public function getMsg()
    {
        return $this->msg;
    }
}

// Instantiate and handle the request
try {
    $addApporteurController = new addApporteurController();
    $addApporteurController->handleRequest();
} catch (\Throwable $th) {
    echo "Une erreur est survenue: " . $th->getMessage();
}
