<?php

class Campagne {
    private $id_campagne;
    private $code_campagne;
    private $nom_campagne;
    private $created_at;
    private $modified_at;

    /****** ID CAMPAGNE  ******/ 
    public function getIdCampagne()
    {
        return $this->id_campagne;
    }

    public function setIdCampagne($id_campagne)
    {
        $this->id_campagne = $id_campagne;
    }

    /****** CODE CAMPAGNE  ******/ 
    public function getCode_campagne()
    {
        return $this->code_campagne;
    }

    public function setCode_campagne($code_campagne)
    {
        $this->code_campagne = $code_campagne;
    }

    /****** NOM CAMPAGNE ******/ 
    public function getNom_campagne()
    {
        return $this->nom_campagne;
    }

    public function setNom_campagne($nom_campagne)
    {
        $this->nom_campagne = $nom_campagne;
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