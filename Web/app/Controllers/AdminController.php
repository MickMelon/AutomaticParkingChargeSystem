<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;

class AdminController
{
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