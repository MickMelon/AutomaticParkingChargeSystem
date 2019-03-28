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

    /**
     * Gets a single parking log.
     *
     * @param string $reg The vehicle registration number.
     * @param datetime $entryDateTime The time and date that they entered the car park.
     */
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

    /**
     * Calculates the cost for the time that a vehicle spent in the car park.
     *
     * @param string $reg The vehicle registration number.
     * @param datetime $entryDateTime The time and date that they entered the car park.
     * @param double $hourlyRate The hourly rate.
     */
    public function calculateCosts($reg, $entryDateTime, $hourlyRate)
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

        $totalCost = ceil($hours) * $hourlyRate;

        return $totalCost;
    }

    /**
     * Adds a new parking entry.
     *
     * @param string $reg The vehicle registration number.
     * @param int $carparkId The carpark ID.
     * @return void
     */
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

    /**
     * Updates a parking entry to set the exit date and time.
     *
     * @param string $reg The vehicle registration number.
     */
    public function addExit($reg)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Parking` SET `ExitDateTime` = NOW()"
            . " WHERE `Reg` = :reg AND `ExitDateTime` IS NULL OR `ExitDateTime` = '0000-00-00 00:00:00' LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->execute();
    }

    /**
     * Gets the latest parking log for a vehicle.
     *
     * @param string $reg The vehicle registration number.
     */
    public function getLatestParking($reg)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Parking` WHERE `Reg` = :reg AND `ExitDateTime` <> '0000-00-00 00:00:00' ORDER BY `ExitDateTime` DESC LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':reg', $reg, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch();
    }

    /**
     * Checks if the vehicle is currently in a car park. This is determined by whether the ExitDateTime
     * has been set.
     *
     * @param string $reg The vehicle registration number.
     * @return boolean Whether the vehicle is in the car park.
     */
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

    /**
     * Set a parking entry to be paid for.
     *
     * @param string $reg The vehicle registration number.
     * @param datetime $entryDateTime The date and time the vehicle entered the car park.
     */
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