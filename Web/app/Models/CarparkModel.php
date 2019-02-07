<?php
namespace App\Models;

use App\Database;
use PDO;

class CarparkModel
{
    public function getAllCarparks()
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Carpark`";
        $query = $db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    public function getCarparkById($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Carpark` WHERE `ID` = :id LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

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