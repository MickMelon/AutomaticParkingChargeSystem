<?php
namespace App\Models;

use App\Database;
use PDO;

/**
 * Used for interacting with the Parking table in the database.
 */
class ParkingModel
{
    /**
     * Get all the parking logs for the specified car park.
     * 
     * @param int $carparkId The ID of the car park.
     * 
     * @return array All the retrieved logs.
     */
    public function getAllForCarpark($carparkId)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Parking` WHERE `CarparkID` = :id";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $carparkId, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll();
    }

    public function addEntry($reg, $carparkId)
    {
        $db = Database::getInstance();

        $sql = "INSERT INTO `Parking` (`Reg`, `EntryDateTime`, `CarparkID`)"
            . " VALUES (:reg, NOW(), :carparkId)";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->bindParam(':carparkId', $carparkId, PDO::PARAM_INT);
        $query->execute();
    }

    public function addExit($reg)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Parking` SET `ExitDateTime` = NOW()"
            . " WHERE `Reg` = :reg AND `ExitDateTime` IS NULL OR `ExitDateTime` = '0000-00-00 00:00:00' LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }

    public function isInCarpark($reg)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Parking` WHERE `Reg` = :reg AND `ExitDateTime` IS NULL OR `ExitDateTime` = '0000-00-00 00:00:00' LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->execute();

        $parkingEntry = $query->fetch();
        return ($parkingEntry != null);
    }
}