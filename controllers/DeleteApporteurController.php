<?php
require_once(__DIR__ . '/../config/autoload.php');

class DeleteApporteurController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function handleRequest()
    {
        try {
            // Fetch and validate apporteur ID
            $id_apporteur = $this->getValidatedApporteurId();

            // Attempt to delete the apporteur
            $this->deleteApporteurById($id_apporteur);

            // Redirect with success message
            $this->redirectWithMessage('L\'apporteur a été supprimé avec succès.');
        } catch (\Throwable $th) {
            // Redirect with error message
            $this->redirectWithMessage('Une erreur est survenue : ' . $th->getMessage());
        }
    }

    public function getValidatedApporteurId(): int
    {
        $id_apporteur = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

        if (!$id_apporteur) {
            throw new Exception('ID d\'apporteur invalide.');
        }

        return $id_apporteur;
    }

    public function deleteApporteurById(int $id_apporteur): void
    {
        $apporteur = ApporteurManager::getApporteurById($id_apporteur);

        if (!$apporteur) {
            throw new Exception('L\'apporteur n\'existe pas.');
        }

        // Get apporteur code for logging
        $code_apporteur = $apporteur->getCode_Apporteur();

        ApporteurManager::deleteApporteur($id_apporteur);

        $logManager = new LogManager();

        $logManager->logDeleteCode($code_apporteur, $_SESSION['username']);
    }

    private function redirectWithMessage(string $msg): void
    {
        $_SESSION['msg'] = $msg;
        header('Location:'.$_ENV['URL_PROD'].'/controllers/ListApporteurController.php');
        die;
    }
}

try {
    $deleteApporteurcontroller = new DeleteApporteurController();
    $deleteApporteurcontroller->handleRequest();
} catch (\Throwable $th) {
    echo "Une erreur est survenue: " . $th->getMessage();
}
