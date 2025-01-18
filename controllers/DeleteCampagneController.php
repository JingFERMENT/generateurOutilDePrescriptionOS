<?php
require_once(__DIR__ . '/../config/autoload.php');

class DeleteCampagneController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function handleRequest()
    {
        try {
            // Fetch and validate apporteur ID
            $id_campagne = $this->getValidatedCampagneId();

            // Attempt to delete the apporteur
            $this->deleteApporteurById($id_campagne);

            // Redirect with success message
            $this->redirectWithMessage('La campagne a été supprimée avec succès.');
        } catch (\Throwable $th) {
            // Redirect with error message
            $this->redirectWithMessage('Une erreur est survenue : ' . $th->getMessage());
        }
    }

    public function getValidatedCampagneId(): int
    {
        $id_campagne = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));

        if (!$id_campagne) {
            throw new Exception('ID de campagne invalide.');
        }

        return $id_campagne;
    }

    public function deleteApporteurById(int $id_campagne): void
    {
        $campagne = CampagneManager::getCodeCampagneById($id_campagne);

        if (!$campagne) {
            throw new Exception('La campagne n\'existe pas.');
        }

        // Get apporteur code for logging
        $code_campagne = $campagne->getCode_Campagne();

        CampagneManager::deleteCampagne($id_campagne);

        $logManager = new LogManager();

        $logManager->logDeleteCode($code_campagne, $_SESSION['username']);
    }

    private function redirectWithMessage(string $msg): void
    {
        $_SESSION['msg'] = $msg;
        header('Location:'.$_ENV['URL_PROD'].'/controllers/ListCampagneController.php');
        die;
    }
}


try {
    $deleteCampagneController = new DeleteCampagneController();
    $deleteCampagneController->handleRequest();
} catch (\Throwable $th) {
    echo "Une erreur est survenue: " . $th->getMessage();
}
