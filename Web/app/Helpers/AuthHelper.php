<?php 
namespace App\Helpers;

use App\Models\UserModel;

/**
 * Contains Helper methods for authentication purposes.
 */
class AuthHelper 
{
    /**
     * Checks if the user is logged in.
     * 
     * @return bool Whether the user is logged in.
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['id']) && isset($_SESSION['token']);
    }

    /**
     * Checks if the user is an admin.
     * 
     * @return bool Whether the user is an admin.
     */
    public static function isAdmin()
    {
        if (!AuthHelper::isLoggedIn()) return false;

        $userModel = new UserModel();
        $user = $userModel->getUserById($_SESSION['id']);
        
        return $user->Role > 0;
    }
}