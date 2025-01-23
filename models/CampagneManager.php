<?php
require_once(__DIR__.'/../config/autoload.php');

class CampagneManager
{

    /**
     * Retrieve all campaigns from the database
     * 
     * @return array
     */
    public static function getAllCodesCampagne(): array
    {
        $pdo = DBConnect::getPDO();

        $sql = "SELECT * FROM `campagne`;";

        $sth = $pdo->prepare($sql);
        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    /**
     * Retrieve a specific campaign by its ID
     * 
     * @param int $id_campagne
     * 
     * @return Campagne
     */
    public static function getCodeCampagneById(int $id_campagne): Campagne
    {
        $pdo = DBConnect::getPDO();

        $sql = "SELECT * FROM campagne WHERE `id_campagne` = :id_campagne";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_campagne', $id_campagne, PDO::PARAM_INT);

        $sth->execute();

        $data = $sth->fetch(PDO::FETCH_OBJ);

        if (!$data) {

            throw new Exception('Le code de campagne que vous avez demandé n\'existe pas.');
        } else {

            $newCampagne = new Campagne();

            $newCampagne->setIdCampagne($data->id_campagne);
            $newCampagne->setCode_campagne($data->code_campagne);
            $newCampagne->setNom_campagne($data->nom_campagne);

            return $newCampagne;
        }
    }


    /**
     * Add a new campaign and associate it with multiple apporteur codes
     *
     */
    public static function addCodeCampagne($campagne, $idApporteurs)
    {
        $pdo = DBConnect::getPDO();

        // Insert a new campaign into the database
        $sql = "INSERT INTO `campagne` (`code_campagne`, `nom_campagne`, `created_at`) VALUES (:code_campagne, :nom_campagne, NOW())";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_campagne', $campagne->getCode_campagne());
        $sth->bindValue(':nom_campagne', $campagne->getNom_campagne());

        $sth->execute();

        if ($sth->rowCount() <= 0) {
            throw new Exception('Erreur lors de l\'enregistrement du code de campagne');
        }

        $campagneId = $pdo->lastInsertId();

        // Link the campaign with apporteur codes
        $sql2 = "INSERT INTO `campagne_apporteur` (`id_campagne`, `id_apporteur`) VALUES (:id_campagne, :id_apporteur);";

        foreach ($idApporteurs as $idApporteur) {

            $sth2 = $pdo->prepare($sql2);

            $sth2->bindValue(':id_campagne', $campagneId, PDO::PARAM_INT);
            $sth2->bindValue(':id_apporteur', $idApporteur,PDO::PARAM_INT);

            $sth2->execute();

            if ($sth2->rowCount() <= 0) {
                throw new Exception('Erreur lors de l\'enregistrement du lien entre le code de campagne et d\'apporteur');
            }
        }

        return true;
    }

   
    /**
     * Check if a campaign code exists in the database
     * 
     * @param string $code_campagne
     * 
     * @return bool
     */
    public static function isExist(string $code_campagne): bool
    {

        $pdo = DBConnect::getPDO();

        $sql = 'SELECT COUNT(*) FROM `campagne` WHERE `code_campagne` = :code_campagne';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_campagne', $code_campagne);

        $sth->execute();

        $rowCount = $sth->fetchColumn();

        return $rowCount > 0;
    }

    /**
     * Check if a campaign ID exists in the database
     * 
     * @param int $idCampagne
     * 
     * @return bool
     */
    public static function isExistIdCampagne(int $idCampagne): bool
    {

        $pdo = DBConnect::getPDO();

        $sql = 'SELECT COUNT(*) FROM `campagne` WHERE `id_campagne` = :id_campagne';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_campagne', $idCampagne);

        $sth->execute();

        $rowCount = $sth->fetchColumn();

        return $rowCount > 0;
    }

  
    /**
     * Get all apporteur codes associated with a specific campaign ID
     * 
     * @param int $id_campagne
     * 
     * @return array
     */
    public static function getAllCodesApporteurByCodeCampagne(int $id_campagne): array
    {
        $pdo = DBConnect::getPDO();

        $sql = "SELECT `apporteur`.`code_apporteur`
            FROM `campagne_apporteur`
            JOIN `campagne` 
                ON `campagne_apporteur`.`id_campagne` = `campagne`.`id_campagne`
            JOIN  `apporteur`
                ON `campagne_apporteur`.`id_apporteur` = `apporteur`.`id_apporteur`
            WHERE `campagne_apporteur`.`id_campagne` = :id_campagne";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_campagne', $id_campagne, PDO::PARAM_INT);

        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_COLUMN);

        return $data;
    }

    /**
     * Get all informations about apporteurs with a specific campaign ID
     * 
     * @param string $id_campagne
     * 
     * @return array
     */
    public static function getAllApporteurByCodeCampagne(string $id_campagne): array
    {
        $pdo = DBConnect::getPDO();

        $sql = "SELECT `apporteur`.*
            FROM `campagne_apporteur`
            JOIN `campagne` 
                ON `campagne_apporteur`.`id_campagne` = `campagne`.`id_campagne`
            JOIN  `apporteur`
                ON `campagne_apporteur`.`id_apporteur` = `apporteur`.`id_apporteur`
            WHERE `campagne_apporteur`.`id_campagne` = :id_campagne";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_campagne', $id_campagne, PDO::PARAM_INT);

        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

  
    /**
     * Get all code apporteurs without duplicate
     * 
     * @return array
     */
    public static function getAllCodesApporteurs(): array
    {
        $pdo = DBConnect::getPDO();

        $sql = "SELECT DISTINCT `code_apporteur`, `id_apporteur` FROM `apporteur`";

        $sth = $pdo->prepare($sql);

        $sth->execute();

        $data = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

   
    public function updateCodeCampagne($campagne, $idApporteurs): bool
    {
        $pdo = DBConnect::getPDO();

        // Update the existing 'campagne' record with the new data
        $sql = "UPDATE `campagne` SET 
         `code_campagne` =:code_campagne,
         `nom_campagne` =:nom_campagne,
         `modify_at` = NOW()
         WHERE `id_campagne` =:id_campagne;";

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':code_campagne', $campagne->getCode_campagne());
        $sth->bindValue(':nom_campagne', $campagne->getNom_campagne());
        $sth->bindValue(':id_campagne', $campagne->getIdCampagne(), PDO::PARAM_INT);
        $result = $sth->execute();
    
        if ($result === false) {
            throw new Exception('Erreur lors de l\'enregistrement de la campagne.');
        }

        // If new apporteurs are provided, update their relationships with the campaign
        if (!empty($idApporteurs)) {
     
            /// Step 1: Delete existing relationships for the campaign
                $sql2 = "DELETE FROM `campagne_apporteur` 
                    WHERE `id_campagne` = :id_campagne;";

                $sth2 = $pdo->prepare($sql2);

                $sth2->bindValue(':id_campagne', $campagne->getIdCampagne(), PDO::PARAM_INT);

                $result2 = $sth2->execute();

                if ($result2 === false) {
                    throw new Exception('Erreur lors de l\'enregistrement des apporteurs.');
                }

            // Step 2: Insert the new relationships into the 'campagne_apporteur' table
            $sql3 = "INSERT INTO `campagne_apporteur` (`id_campagne`, `id_apporteur`) VALUES (:id_campagne, :id_apporteur);";

            foreach ($idApporteurs as $idApporteur) {
                
                $sth3 = $pdo->prepare($sql3);

                $sth3->bindValue(':id_campagne', $campagne->getIdCampagne(), PDO::PARAM_INT);
                $sth3->bindValue(':id_apporteur', $idApporteur, PDO::PARAM_INT);

                $result3 = $sth3->execute();

                if ($result3 === false) {
                    throw new Exception('Erreur lors de l\'enregistrement du lien entre le code de campagne et d\'apporteur');
                }
            }
            
        } else {
            // If no apporteurs are selected, delete all existing relationships
            $sql4 = "DELETE FROM `campagne_apporteur` 
                    WHERE `id_campagne` = :id_campagne;";

                $sth4 = $pdo->prepare($sql4);

                $sth4->bindValue(':id_campagne', $campagne->getIdCampagne(), PDO::PARAM_INT);

                $result4 = $sth4->execute();

                if ($result4 === false) {
                    throw new Exception('Erreur lors de l\'enregistrement des apporteurs.');
                }

        }

        return true;
    }


    
    /**
     * 
     * Deletes a campaign and its associated apporteur relationships.
     * 
     * @param int $id_campagne
     * 
     * @return bool
     */
    public static function deleteCampagne(int $id_campagne) :bool
    {

        $pdo = DBConnect::getPDO();

        // Step 1: Delete the relationships in the 'campagne_apporteur' table (table child first)
        $sql = 'DELETE FROM `campagne_apporteur` WHERE `id_campagne` =:id_campagne;';

        $sth = $pdo->prepare($sql);

        $sth->bindValue(':id_campagne', $id_campagne, PDO::PARAM_INT);

        $result = $sth->execute();

        if(!$result) {
            throw new Exception('Erreur lors de la suppression des enregistrements dans campagne_apporteur.');
        }

        // Step 2: Delete the campaign from the 'campagne' table
        $sql2 = 'DELETE FROM `campagne` WHERE `id_campagne` =:id_campagne;';

        $sth2 = $pdo->prepare($sql2);

        $sth2->bindValue(':id_campagne', $id_campagne, PDO::PARAM_INT);

        $result2 = $sth2->execute();

        if (!$result2) {
            throw new Exception('Erreur lors de la suppression de la campagne.');
        }
            return true;
        
    }


}
