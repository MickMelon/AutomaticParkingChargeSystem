<?php
namespace App\Models;

use App\Database;
use PDO;

/**
 * Used for interacting with the Config table in the database.
 */
class ConfigModel 
{
    /**
     * Constants for the config table in the database
     */
    const PERMIT_PRICE = 'PermitPrice'; 

    /**
     * Gets a config value by the name. Use the constants in this class 
     * instead of writing the actual name.
     * 
     * @param string $name The config name (matches `Name` column in database)
     * 
     * @return string The value of the config (varchar)
     */
    public function getConfigValue($name)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Config` WHERE `Name` = :name LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->execute();

        $config = $query->fetch();
        return $config->Value;
    }

    /**
     * Sets a config value by the name.
     * 
     * @param string $name The config name (matches `Name` column in database)
     * @param string $value The desired value.
     * 
     * @return void
     */
    public function setConfigValue($name, $value)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `Config` SET `Value` = :value WHERE `Name` = :name";
        $query = $db->prepare($sql);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':value', $value, PDO::PARAM_STR);
        $query->execute();
    }
}