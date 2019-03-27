<?php
namespace App\Models;

use App\Database;
use PDO;
use App\Config;

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

    public function getSingle($reg, $entryDateTime)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Parking` WHERE `Reg` = :reg AND `EntryDateTime` = :entryDateTime LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->bindParam(':entryDateTime', $entryDateTime, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch();
    }

    public function calculateCosts($reg, $entryDateTime)
    {
        $db = Database::getInstance();

        $sql = "SELECT HOUR(TIMEDIFF(`EntryDateTime`, `ExitDateTime`)) AS `Hours`"
            . " FROM `Parking`"
            . " WHERE `Reg` = :reg AND `EntryDateTime` = :entryDateTime LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->bindParam(':entryDateTime', $entryDateTime, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch();
        $hours = $result->Hours;

        $totalCost = ceil($hours) * Config::HOURLY_PARKING_RATE_POUNDS;

        return $totalCost;
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

    public function getLatestParking($reg)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Parking` WHERE `Reg` = :reg AND `ExitDateTime` <> '0000-00-00 00:00:00' ORDER BY `ExitDateTime` DESC LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch();
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

    public function setPaid($reg, $entryDateTime)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Parking` SET `Paid` = 1 WHERE `Reg` = :reg AND `EntryDateTime` = :entryDateTime LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->bindParam(':entryDateTime', $entryDateTime, PDO::PARAM_STR);
        $query->execute();
    }
}