<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;

/**
 * Used for controlling admin actions.
 */
class AdminController
{
    /**
     * The User Model for interacting with the database.
     */
    private $userModel;

    /**
     * Creates a new AdminController object.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Shows the admin panel.
     * 
     * @return void
     */
    public function index()
    {
        if (!AuthHelper::isAdmin())
            exit(header('Location: index.php'));

        $view = new View('Admin/index');
        $view->assign('pageTitle', 'Admin Panel');
        $view->render();
    }   
}