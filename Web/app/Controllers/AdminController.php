<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ConfigModel;
use App\Models\VehicleModel;
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
     * The Config Model for interacting with the database.
     */
    private $configModel;

    /**
     * The Vehicle Model for interacting with the database.
     */
    private $vehicleModel;

    /**
     * Creates a new AdminController object.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->configModel = new ConfigModel();
        $this->vehicleModel = new VehicleModel();
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

    /**
     * Shows the permit settings page.
     */
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

    /**
     * Called when the update permit price form is submitted.
     */
    public function updatePermitPrice()
    {
        if (!AuthHelper::isAdmin() || !isset($_POST['price']))
            exit(header('Location: index.php'));

        $price = $_POST['price'];
        $this->configModel->setConfigValue(ConfigModel::PERMIT_PRICE, $price);

        header('Location: index.php?controller=admin&action=permits');
    }

    /**
     * Called when the remove all permits form is submitted.
     */
    public function removeAllPermits()
    {
        if (!AuthHelper::isAdmin())
            exit(header('Location: index.php'));

        $this->vehicleModel->removePermitFromAllVehicles();
        header('Location: index.php?controller=admin&action=permits');
    }
}