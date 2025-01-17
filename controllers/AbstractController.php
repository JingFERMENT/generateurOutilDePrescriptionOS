<?php

abstract class AbstractController {
    
    // protected string $title;

    public function __construct()
    {
        session_start();
        Auth::verifyIsConnected();
    }
    
}