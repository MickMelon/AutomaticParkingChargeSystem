<?php
namespace App\Models;

use App\Database;
use PDO;

class UserModel 
{
    /**
     * Gets a User by their ID.
     */
    public function getUserById($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Customer` WHERE `ID` = :id LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

    /**
     * Gets a User by their email address.
     */
    public function getUserByEmail($email)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `Customer` WHERE `Email` = :email LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch();
    }

    /**
     * Gets a User by their email and password, used for 
     * the login.
     */
    public function getUserByEmailPassword($email, $password)
    {
        $User = $this->getUserByEmail($email);

        if ($User != null && password_verify($password, $User->Password))
            return $User;

        return null;
    }

    /**
     * Inserts a new User into the database.
     */
    public function createUser($firstName, $lastName, $email, $password)
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