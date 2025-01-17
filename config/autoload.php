<?php
// register a function to be called for class autoloading
spl_autoload_register(function ($className) {

    if (file_exists(__DIR__. '/../services/' . $className . '.php')) {

        require_once __DIR__.'/../services/' . $className . '.php';
    }

    if (file_exists(__DIR__. '/../models/' . $className . '.php')) {

        require_once __DIR__. '/../models/'. $className . '.php';
    }

    if (file_exists(__DIR__. '/../controllers/' . $className . '.php')) {

        require_once __DIR__. '/../controllers/' . $className . '.php';
    }

    if(file_exists(__DIR__. '/../config/' . $className . '.php')) {

        require_once __DIR__. '/../config/' . $className . '.php';
    }
    
    if(file_exists(__DIR__. '/../views/' . $className . '.php')) {

        require_once __DIR__. '/../views/' . $className . '.php';
    }

});