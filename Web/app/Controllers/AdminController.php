<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ConfigModel;
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
    private $configModel;

    /**
     * Creates a new AdminController object.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->configModel = new ConfigModel();
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

    public function permits()
    {
        if (!AuthHelper::isAdmin())
            exit(header('Location: index.php'));

        $value = $this->configModel->getConfigValue(ConfigModel::PERMIT_PRICE);
        $price = floatval($value);

        $view = new View('Admin/permits');
        $view->assign('pageTitle', 'Permits - Admin Panel');
        $view->assign('price', $price);
        $view->render();
    }
}