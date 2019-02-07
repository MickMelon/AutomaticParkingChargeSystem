<?php
namespace App\Models;

use App\Database;
use PDO;

class CarparkModel
{
    /**
     * Gets all the car parks in the database.
     * 
     * @return array All the car parks.
     */
    public function getAllCarparks()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Carpark`";
        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Gets a car park by its ID.
     * 
     * @param int $id The car park ID.
     * 
     * @return object The car park or null if not found.
     */
    public function getCarparkById($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Carpark` WHERE `ID` = :id LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

    /**
     * Updates a car park.
     * 
     * @param int $id The car park ID.
     * @param string $name The new car park name.
     * @param double $price The new car park price.
     */
    public function updateCarpark($id, $name, $price)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Carpark` SET "
            . " `Name` = :name,"
            . " `Price` = :price"
            . " WHERE `ID` = :id";
        $query = $db->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':price', $price, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();
    }
}