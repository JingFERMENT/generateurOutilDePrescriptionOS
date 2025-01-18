<?php
require_once(__DIR__.'/../config/autoload.php');

class LogoutController {

    public function handleLogout() {

        session_start();
        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            // Log the logout event
            $logManager = new LogManager();
            $logManager->logUserLogout($username);

            // Clear the session
            session_unset();
            session_destroy();

            // Redirect to the login page
            header('Location:'.$_ENV['URL_PROD'].'/');
            exit;
        } 
    }
}

try {
    $logoutController = new LogoutController();
    $logoutController->handleLogout();
} catch (\Throwable $th) {
    echo "Une erreur est survenue: " . $th->getMessage();
}