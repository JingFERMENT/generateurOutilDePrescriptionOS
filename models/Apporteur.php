<?php

class Apporteur {

    private int $id_apporteur;
    private string $code_apporteur;
    private string $nom_apporteur;
    private DateTime $created_at;
    private DateTime $modified_at;

    /****** ID APPORTEUR  ******/ 
    public function getIdApporteur():int
    {
        return $this->id_apporteur;
    }

    public function setIdApporteur(int $id_apporteur):void
    {
        $this->id_apporteur = $id_apporteur;
    }

    /****** CODE APPORTEUR  ******/ 
    public function getCode_apporteur():string
    {
        return $this->code_apporteur;
    }

    public function setCode_apporteur(string $code_apporteur):void
    {
        $this->code_apporteur = $code_apporteur;
    }

    /****** NOM APPORTEUR  ******/ 
    public function getNom_apporteur():string
    {
        return $this->nom_apporteur;
    }

    public function setNom_apporteur(string $nom_apporteur):void
    {
        $this->nom_apporteur = $nom_apporteur;
    }

    /****** CREATED AT  ******/ 

    public function getCreated_at():DateTime
    {
        return $this->created_at;
    }

    public function setCreated_at(DateTime $created_at):void
    {
        $this->created_at = $created_at;
    }

    /****** MODIFIED AT  ******/  
    public function getModified_at():DateTime
    {
        return $this->modified_at;
    }

  
    public function setModified_at(DateTime $modified_at):void
    {
        $this->modified_at = $modified_at;

    }
}