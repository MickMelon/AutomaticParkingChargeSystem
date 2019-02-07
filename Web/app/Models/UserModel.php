<?php
namespace App\Models;

use App\Database;
use PDO;

/**
 * Used for interacting with the User table in the database.
 */
class UserModel 
{
    /**
     * Gets a user by their ID.
     * 
     * @param int $id The User ID.
     * 
     * @return object The User.
     */
    public function getUserById($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `User` WHERE `ID` = :id LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

    /**
     * Gets a user by their email address.
     * 
     * @param string $email The User's email address.
     * 
     * @return object The User.
     */
    public function getUserByEmail($email)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `User` WHERE `Email` = :email LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        return $query->fetch();
    }

    /**
     * Gets a user by their email and password, used for 
     * the login.
     * 
     * @param string $email The User's email address.
     * @param string $password The User's plain-text password.
     * 
     * @return object The User.
     */
    public function getUserByEmailPassword($email, $password)
    {
        $user = $this->getUserByEmail($email);

        if ($user != null && password_verify($password, $user->Password))
            return $user;

        return null;
    }

    /**
     * Inserts a new user into the database.
     * 
     * @param string $firstName The User's first name.
     * @param string $lastName The User's last name.
     * @param string $email The User's email address.
     * @param string $password The User's password in plain-text.
     * 
     * @return void
     */
    public function createUser($firstName, $lastName, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = Database::getInstance();

        $sql = "INSERT INTO `User` (`FirstName`, `LastName`, `Email`, `Password`)"
            . " VALUES (:firstName, :lastName, :email, :password)";
        $query = $db->prepare($sql);
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $hash, PDO::PARAM_STR);

        $query->execute();
    }

    /**
     * Updates a user.
     * 
     * @param string $firstName The User's first name.
     * @param string $lastName The User's last name.
     * @param string $email The User's email address.
     * @param string $password The User's password in plain-text.
     * 
     * @return void
     */
    public function updateUser($id, $firstName, $lastName, $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = Database::getInstance();

        $sql = "UPDATE `User` SET "
            . " `FirstName` = :firstName,"
            . " `LastName` = :lastName,"
            . " `Password` = :password"
            . " WHERE `ID` = :id";
        $query = $db->prepare($sql);
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':password', $hash, PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();
    }
}