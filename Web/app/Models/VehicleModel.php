<?php
namespace App\Models;

use App\Database;
use PDO;

/**
 * Used for interacting with the Vehicle table in the database.
 */
class VehicleModel 
{
    /**
     * Gets a vehicle by the reg.
     * 
     * @param string $reg The vehicle registration number.
     * 
     * @return object The Vehicle.
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
     * 
     * @param int $userId The User ID.
     * 
     * @return object All the user's vehicles as an array.
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
     * 
     * @param string $reg The vehicle registration number.
     * @param int $userId The User ID.
     * 
     * @return void
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
     * 
     * @param string $reg The vehicle registration number.
     * 
     * @return void
     */
    public function deleteVehicle($reg)
    {
        $db = Database::getInstance();

        $sql = "DELETE FROM `Vehicle` WHERE `Reg` = :reg";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }

    /**
     * Adds a permit to a vehicle.
     * 
     * @param string $reg The vehicle registration number.
     * 
     * @return void
     */
    public function addPermit($reg)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Vehicle` SET `HasPermit` = 1 WHERE `Reg` = :reg LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }

    /**
     * Removes a permit from a vehicle.
     * 
     * @param string $reg The vehicle registration number.
     * 
     * @return void
     */
    public function removePermit($reg)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Vehicle` SET `HasPermit` = 0 WHERE `Reg` = :reg LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }

    /**
     * Removes permit for all vehicles.
     * 
     * @return void
     */
    public function removePermitFromAllVehicles()
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Vehicle` SET `HasPermit` = 0";
        $query = $db->prepare($sql);
        $query->bindParam('reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }
}