<?php
require_once(__DIR__ . '/../vendor/autoload.php');

// Initialize the Dotenv library to load environment variables from the .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

// parameters for the regex
define('REGEXMATRICULE', 'C\d{6}$');
define('REGEXIDPART', '^\d{14}$');
define('REGEXCODE', '^[a-zA-Z0-9]+$');