<?php

class Apporteur {

    private int $id_apporteur;
    private string $code_apporteur;
    private string $nom_apporteur;
    private DateTime $created_at;
    private DateTime $modified_at;

    /****** ID APPORTEUR  ******/ 
    public function getIdApporteur()
    {
        return $this->id_apporteur;
    }

    public function setIdApporteur($id_apporteur)
    {
        $this->id_apporteur = $id_apporteur;
    }

    /****** CODE APPORTEUR  ******/ 
    public function getCode_apporteur()
    {
        return $this->code_apporteur;
    }

    public function setCode_apporteur($code_apporteur)
    {
        $this->code_apporteur = $code_apporteur;
    }

    /****** NOM APPORTEUR  ******/ 
    public function getNom_apporteur()
    {
        return $this->nom_apporteur;
    }

    public function setNom_apporteur($nom_apporteur)
    {
        $this->nom_apporteur = $nom_apporteur;
    }

    /****** CREATED AT  ******/ 

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    /****** MODIFIED AT  ******/  
    public function getModified_at()
    {
        return $this->modified_at;
    }

  
    public function setModified_at($modified_at)
    {
        $this->modified_at = $modified_at;

    }
}