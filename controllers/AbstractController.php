<?php

abstract class AbstractController {

    public function __construct()
    {
        session_start();
        Auth::verifyIsConnected();
    }
    
}