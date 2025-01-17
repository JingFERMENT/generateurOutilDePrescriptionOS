<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__.'/../config/autoload.php');

// logs 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class logManager
{
    private $logger;

    /**
     * 
     * Constructor to initialize the logger with a specific channel name and log file path.
     * 
     * @param string $channelName
     * @param string $logFile: the relative path to the log file.
     * 
     */
    public function __construct(string $channelName = 'Générateur_liens', string $logFile = '/../logs/app.log')
    {
        // Set the timezone for logging timestamps
        date_default_timezone_set('Europe/Paris');

        // Create a new logger instance with the specified channel name
        $this->logger = new Logger($channelName);

        // Add a handler to the logger with a custom formatter
        $handler = new StreamHandler(__DIR__ . $logFile, Logger::INFO);

        // Define the log message format
        $output = "[%datetime%] %channel%.%level_name%: %message%\n";
        $formatter = new LineFormatter($output, null, false, true);

        // Apply the formatter to the handler
        $handler->setFormatter($formatter);
        
        // Add the handler to the logger
        $this->logger->pushHandler($handler);
    }

    /**
     * 
     * This method logs an informational message whenever a new code is added by a user.
     * 
     * @param string $code : the code being added.
     * @param string $username : the user performing the action.
     * 
     * @return void
     */
    public function logAddCode(string $code, string $username): void
    {

        $this->logger->info('Code "' .$code. '" is added by ' . $username . '.');
    }


    /**
     * 
     * This method logs an informational message whenever a new code is modified by a user.
     * 
     * @param string $code : the code being modified.
     * @param string $username : the user performing the action.
     * 
     * @return void
     */
    public function logModifyCode(string $code, string $username): void 
    {
        $this->logger->info('Code "' .$code. '" is modified by ' . $username . '.');
    }


    /**
     * 
     * This method logs an informational message whenever a new code is deleted by a user.
     * 
     * @param string $code
     * @param string $username
     * 
     * @return void
     */
    public function logDeleteCode(string $code, string $username): void 
    {

        $this->logger->info('Code "' .$code. '" is deleted by ' . $username . '.');
    }

    /**
     * 
     * This method logs an informational message whenever an email is sent by a user.
     * 
     * @param string $recipient
     * @param string $username
     * 
     * @return void
     */
    public function logMailSent(string $recipient, string $username): void 
    {

        $this->logger->info('Mail sent to ' .$recipient. ' by ' . $username . '.');
    }


  
    /**
     * 
     * This method logs an informational message whenever a user is connected.
     * 
     * @param string $username
     * 
     * @return void
     */
    public function logUserSignup(string $userRole, string $username): void 
    {
        if($userRole === 'admin') {
            $this->logger->info('Administrator ' .$username.' is connected now.');
        } else  {
            $this->logger->info('User ' .$username.' is connected now.');
        }
       
    }


     /**
     * 
     * This method logs an informational message whenever a user logged out.
     * 
     * @param string $username
     * 
     * @return void
     */
    public function logUserLogout(string $username): void 
    {

        $this->logger->info('User ' .$username.' has logged out now.');
    }

}
