<?php
namespace App\Models;

use App\Database;
use PDO;

class VehicleModel 
{
    /**
     * Gets a vehicle by the reg.
     */
    public function getVehicle($reg)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Vehicle` WHERE `Reg` = :reg LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch();
    }

    /**
     * Gets all vehicles for a user
     */
    public function getAllVehiclesForUser($userId)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Vehicle` WHERE `UserID` = :userId";
        $query = $db->prepare($sql);
        $query->bindParam(':userId', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Creates a new vehicle.
     */
    public function createVehicle($reg, $userId)
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO `Vehicle` (`Reg`, `UserID`)"
            . " VALUES (:reg, :userId)";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->bindParam('userId', $userId, PDO::PARAM_INT);
        $query->execute();
    }

    /**
     * Permanently deletes a vehicle.
     */
    public function deleteVehicle($reg)
    {
        $db = Database::getInstance();

        $sql = "DELETE FROM `Vehicle` WHERE `Reg` = :reg";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }

    public function addPermit($reg)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Vehicle` SET `HasPermit` = 1 WHERE `Reg` = :reg";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }

    public function removePermit($reg)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Vehicle` SET `HasPermit` = 0 WHERE `Reg` = :reg";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }
}