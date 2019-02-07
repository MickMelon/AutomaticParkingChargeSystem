<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CarparkModel;
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
        $this->carparkModel = new CarparkModel();
    }

    /**
     * Shows the admin panel.
     */
    public function index()
    {
        if (!AuthHelper::isAdmin())
            header('Location: index.php');

        $view = new View('Admin/index');
        $view->assign('pageTitle', 'Admin Panel');
        $view->render();
    }   

    /**
     * Shows the car parks page.
     */
    public function carparks()
    {
        if (!AuthHelper::isAdmin())
            header('Location: index.php');

        $carparks = $this->carparkModel->getAllCarparks();

        $view = new View('Admin/carparks');
        $view->assign('pageTitle', 'Car Parks');
        $view->assign('carparks', $carparks);
        $view->render();
    }

    public function updateCarpark()
    {
        if (!AuthHelper::isAdmin() || !isset($_GET['id']))
            header('Location: index.php');

        $id = $_GET['id'];
        $carpark = $this->carparkModel->getCarparkById($id);

        $view = new View('Admin/updatecarpark');
        $view->assign('pageTitle', 'Update Car Park');
        $view->assign('carpark', $carpark);
        $view->render();
    }

    public function submitUpdateCarpark()
    {
        if (!AuthHelper::isAdmin() || !isset($_POST['carparkId']))
            header('Location: index.php');

        $id = $_POST['carparkId'];
        $name = $_POST['name'];
        $price = $_POST['price'];

        $this->carparkModel->updateCarpark($id, $name, $price);
        header('Location: index.php?controller=admin&action=carparks');
    }
}