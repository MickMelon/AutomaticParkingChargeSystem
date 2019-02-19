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
}