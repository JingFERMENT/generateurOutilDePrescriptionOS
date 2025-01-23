<?php
require_once(__DIR__ . '/../config/autoload.php');
require_once(__DIR__ . '/../config/init.php');

class SignupController
{

    private string $title;
    private string $errormsg;

    public function __construct()
    {
        session_start();
        $this->title = 'Se connecter';
    }

    public function handleRequest()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->handlePostRequest();
        } else {
            $this->renderView();
        }
    }

    private function handlePostRequest()
    {
        $errors = [];

        // Clean the data
        $matricule = filter_input(INPUT_POST, 'matricule', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password');

        // Validate matricule
        if (empty($matricule)) {
            $errors['matricule'] = 'Le matricule est obligatoire.';
        } else {
            // Validate matricule format
            $isOk = filter_var($matricule, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/' . REGEXMATRICULE . '/')));
            if (!$isOk) {
                $errors['matricule'] = 'Votre matricule est invalide.';
            }
        }

        // Validate password
        if (empty($password)) {
            $errors['password'] = 'Le mot de passe est obligatoire.';
        }

        // If no validation errors
        if (empty($errors)) {
            $this->attemptLogin($matricule, $password);
        } else {
            $this->renderView(compact('errors', 'matricule'));
        }
    }

    private function attemptLogin($matricule, $password)
    {

        // Define users and roles (made only for the demo)
        $credentials = [
            "C123456" => ["password" => "Zhang", "role" => "admin", "redirect" => 'listCampagne'],
            "C123457" => ["password" => "user-GOPOS", "role" => "standard", "redirect" => 'form']
        ];

        if (isset($credentials[$matricule]) && $credentials[$matricule]['password'] === $password) {
            $userRole = $credentials[$matricule]['role'];
            $redirectPath = $credentials[$matricule]['redirect'];

            // Set session variables
            $_SESSION['username'] = $matricule;
            $_SESSION['userRole'] = $userRole;

            // Log user signup
            $logManager = new LogManager();
            $logManager->logUserSignup($userRole, $matricule);

            // Redirect user
            header("Location: $redirectPath");
            exit;
        }

        // Handle invalid credentials
        $this->errormsg = "Matricule ou mot de passe incorrect";
        $this->renderView(['matricule' => $matricule, 'errormsg' => $this->errormsg]);
    }

    private function renderView($data = [])
    {
        // Extract variables from the provided data array
        extract($data);
        $signupController = $this;
        include __DIR__ . '/../views/templates/header.php';
        include __DIR__ . '/../views/signUp.php';
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
     * Get the value of errormsg
     */
    public function getErrormsg()
    {
        return $this->errormsg;
    }
}

try {
    // Run the controller
    $signupController = new SignupController();
    $signupController->handleRequest();
} catch (\Throwable $th) {
    echo $th->getMessage();
}
