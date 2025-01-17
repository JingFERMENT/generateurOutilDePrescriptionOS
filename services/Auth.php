<?php 

class Auth {

    public static function verifyIsConnected() {
        if(empty($_SESSION['username'])) {
            header('Location:'.$_ENV['URL_PROD'].'/');
            die();
        }
    }
}