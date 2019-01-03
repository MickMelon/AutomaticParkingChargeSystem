<?php 
namespace App\Helpers;

use App\Models\UserModel;

class AuthHelper 
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['id']) && isset($_SESSION['token']);
    }

    public static function isAdmin()
    {
        if (!AuthHelper::isLoggedIn()) return false;

        $userModel = new UserModel();
        $user = $userModel->getUserById($_SESSION['id']);
        
        return $user->Role > 0;
    }
}