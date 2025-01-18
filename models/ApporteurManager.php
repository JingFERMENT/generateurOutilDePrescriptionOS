<?php 
require_once(__DIR__.'/../config/autoload.php');

class ApporteurManager {

    /**
     * Retrieves all apporteur codes from the database.
     * 
     * @return array List of apporteur codes.
     */
    public static function getAllCodesApporteur () :array
    {
        $pdo = DBConnect::getPDO();
        
        $sql = "SELECT * FROM `apporteur`;";
        
        $sth = $pdo->prepare($sql);
        $sth->execute();

        $data = $sth ->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    /**
     * 
     * Retrieves a specific apporteur based on its code.
     * 
     * 
     * @param string $code_apporteur
     * 
     * @return array array Apporteur information.
     */
    public static function getOneCodeApporteur (string $code_apporteur):array
    {
        $pdo = DBConnect::getPDO();
        
        $sql = "SELECT * FROM apporteur WHERE `code_apporteur` = :code_apporteur;";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $code_apporteur);

        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_OBJ);
        
        return $data;

    }


    /**
     * 
     * Retrieves the ID of an apporteur using its code.
     * 
     * @param string $code_apporteur
     * 
     * @return int ID of the apporteur.
     */
    public static function getIdApporteur (string $code_apporteur):int
    {
        $pdo = DBConnect::getPDO();
        
        $sql = "SELECT id_apporteur FROM apporteur WHERE `code_apporteur` = :code_apporteur;";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $code_apporteur);

        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_COLUMN);
        
        return $data;

    }

    
    /**
     * 
     * Checks if an apporteur code exists in the database.
     * 
     * @param string $code_apporteur
     * 
     * @return bool True if the code exists, False otherwise.
     */
    public static function isExistCodeApporteur(string $code_apporteur): bool
    {

        $pdo = DBConnect::getPDO();

        $sql = 'SELECT COUNT(*) FROM `apporteur` WHERE `code_apporteur` = :code_apporteur';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $code_apporteur);

        $sth->execute();

        $rowCount = $sth->fetchColumn();

        return $rowCount > 0;
    }

    /**
     * 
     * Checks if an apporteur name exists in the database.
     * 
     * @param string $nom_apporteur
     * 
     * @return bool bool True if the name exists, False otherwise.
     */
    public static function isExistNomApporteur(string $nom_apporteur): bool
    {

        $pdo = DBConnect::getPDO();

        $sql = 'SELECT COUNT(*) FROM `apporteur` WHERE `nom_apporteur` = :nom_apporteur';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':nom_apporteur', $nom_apporteur);

        $sth->execute();

        $rowCount = $sth->fetchColumn();

        return $rowCount > 0;
    }


   
    /**
     * 
     * Adds a new apporteur to the database.
     * 
     * @param object $apporteur
     * 
     * @return bool True if the insertion is successful, False otherwise.
     */
    public static function addCodeApporteur(object $apporteur): bool 
    {

        $pdo = DBConnect::getPDO();

        $sql = "INSERT INTO `apporteur` (`code_apporteur`, `nom_apporteur`, `created_at`) VALUES (:code_apporteur, :nom_apporteur, NOW())";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $apporteur->getCode_apporteur());
        $sth->bindValue(':nom_apporteur', $apporteur->getNom_apporteur());

        $sth->execute();

        if ($sth->rowCount() <= 0) {
            throw new Exception('Erreur lors de l\'enregistrement du code de campagne');
        } else {
            return true;
        }

    }

    
    /**
     * 
     * Retrieves an apporteur object by its ID.
     * 
     * @param int $id_apporteur
     * 
     * @return Apporteur
     */
    public static function getApporteurById(int $id_apporteur) : Apporteur
    {
        $pdo = DBConnect::getPDO();

        $sql = "SELECT * FROM apporteur WHERE `id_apporteur` = :id_apporteur";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_apporteur', $id_apporteur, PDO::PARAM_INT);

        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_OBJ);
       

        if (!$data) {

            throw new Exception('Le code d\'apporteur que vous avez demandé n\'existe pas.');

        } else {
            $newApporteur = new Apporteur();
            
            $newApporteur->setIdApporteur($data->id_apporteur);
            $newApporteur->setCode_apporteur($data->code_apporteur);
            $newApporteur->setNom_apporteur($data->nom_apporteur);
            
            return $newApporteur;
        }
 
    }
    

    /**
     * Updates an existing apporteur in the database.
     * 
     * @param Apporteur $updatedApporteur
     * 
     * @return bool True if the update is successful, False otherwise.
     */
    public static function updatedApporteur(Apporteur $updatedApporteur): bool
    {
        $pdo = DBConnect::getPDO();

        $sql = "UPDATE `apporteur` SET 
         `code_apporteur` =:code_apporteur,
         `nom_apporteur` =:nom_apporteur,
         `modify_at` = NOW()
         WHERE `id_apporteur` =:id_apporteur;";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $updatedApporteur->getCode_apporteur());
        $sth->bindValue(':nom_apporteur', $updatedApporteur->getNom_apporteur());
        $sth->bindValue(':id_apporteur', $updatedApporteur->getIdApporteur(), PDO::PARAM_INT);
        
        $result = $sth->execute();

        if (!$result) {
            throw new Exception('Erreur lors de l\'enregistrement de l\'apporteur.');
        } else {
            return true;
        }
    }


    /**
     * 
     * Deletes an apporteur and its associated records from the database.
     * 
     * @param int $id_apporteur
     * 
     * @return bool
     */
    public static function deleteApporteur(int $id_apporteur):bool
    {

        $pdo = DBConnect::getPDO();

        $sql = "DELETE FROM campagne_apporteur WHERE `id_apporteur` = :id_apporteur;";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_apporteur', $id_apporteur, PDO::PARAM_INT);

        $result = $sth->execute();

        if(!$result) {
            throw new Exception('Erreur lors de la suppression des enregistrements dans campagne_apporteur.');
        }

        $sql2= "DELETE FROM apporteur WHERE `id_apporteur` = :id_apporteur;";

        $sth2 = $pdo->prepare($sql2);

        $sth2->bindValue(':id_apporteur', $id_apporteur, PDO::PARAM_INT);

        $result2 = $sth2->execute();

        if (!$result2) {
            throw new Exception('Erreur lors de la suppression de la campagne.');
        }
            return true;

    } 
}