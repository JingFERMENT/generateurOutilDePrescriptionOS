<?php 
require_once(__DIR__.'/../config/autoload.php');

class ApporteurManager {

    public static function getAllCodesApporteur ()
    {
        $pdo = DBConnect::getPDO();
        
        $sql = "SELECT * FROM `apporteur`;";
        
        $sth = $pdo->prepare($sql);
        $sth->execute();

        $data = $sth ->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public static function getOneCodeApporteur ($code_apporteur)
    {
        $pdo = DBConnect::getPDO();
        
        $sql = "SELECT * FROM apporteur WHERE `code_apporteur` = :code_apporteur;";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $code_apporteur);

        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_OBJ);
        
        return $data;

    }


    public static function getIdApporteur ($code_apporteur)
    {
        $pdo = DBConnect::getPDO();
        
        $sql = "SELECT id_apporteur FROM apporteur WHERE `code_apporteur` = :code_apporteur;";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $code_apporteur);

        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_COLUMN);
        
        return $data;

    }

    
    public static function isExistCodeApporteur($code_apporteur): bool
    {

        $pdo = DBConnect::getPDO();

        $sql = 'SELECT COUNT(*) FROM `apporteur` WHERE `code_apporteur` = :code_apporteur';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_apporteur', $code_apporteur);

        $sth->execute();

        $rowCount = $sth->fetchColumn();

        return $rowCount > 0;
    }

    public static function isExistNomApporteur($nom_apporteur): bool
    {

        $pdo = DBConnect::getPDO();

        $sql = 'SELECT COUNT(*) FROM `apporteur` WHERE `nom_apporteur` = :nom_apporteur';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':nom_apporteur', $nom_apporteur);

        $sth->execute();

        $rowCount = $sth->fetchColumn();

        return $rowCount > 0;
    }


    public static function addCodeApporteur($apporteur): bool 
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

    public static function getApporteurById($id_apporteur) : Apporteur
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