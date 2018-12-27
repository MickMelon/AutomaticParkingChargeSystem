<?php
namespace App\Models;

use App\Database;
use PDO;

class CustomerModel 
{
    /**
     * Gets a customer by their ID.
     */
    public function getCustomerById($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Customer` WHERE `ID` = :id LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Gets a customer by their email address.
     */
    public function getCustomerByEmail($email)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Customer` WHERE `Email` = :email LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':email', $id, PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Gets a customer by their email and password, used for 
     * the login.
     */
    public function getCustomerByEmailPassword($email, $password)
    {
        $customer = $this->getCustomerByEmail($email);

        if (password_verify($password, $customer->Password))
            return $customer;

        return null;
    }

    /**
     * Inserts a new customer into the database.
     */
    public function createCustomer($firstName, $lastName, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = Database::getInstance();

        $sql = "INSERT INTO `Customer` (`FirstName`, `LastName`, `Email`, `Password`)"
            . " VALUES (:firstName, :lastName, :email, :password)";
        $query = $db->prepare($sql);
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $hash, PDO::PARAM_STR);

        $query->execute();
    }
}