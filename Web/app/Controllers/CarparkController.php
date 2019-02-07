<?php
namespace App\Controllers;

use App\Models\CarparkModel;
use App\Helpers\AuthHelper;
use App\View;

class CarparkController
{
    private $carparkModel;

    /**
     * Creates a new CarparkController object.
     */
    public function __construct()
    {
        $this->carparkModel = new CarparkModel();
    }

    /**
     * Shows the car parks page.
     */
    public function index()
    {
        if (!AuthHelper::isAdmin())
            header('Location: index.php');

        $carparks = $this->carparkModel->getAllCarparks();

        $view = new View('Carpark/index');
        $view->assign('pageTitle', 'Car Parks');
        $view->assign('carparks', $carparks);
        $view->render();
    }

    public function update()
    {
        if (!AuthHelper::isAdmin() || !isset($_GET['id']))
            header('Location: index.php');

        $id = $_GET['id'];
        $carpark = $this->carparkModel->getCarparkById($id);

        $view = new View('Carpark/update');
        $view->assign('pageTitle', 'Update Car Park');
        $view->assign('carpark', $carpark);
        $view->render();
    }

    public function submitUpdate()
    {
        if (!AuthHelper::isAdmin() || !isset($_POST['carparkId']))
            header('Location: index.php');

        $id = $_POST['carparkId'];
        $name = $_POST['name'];
        $price = $_POST['price'];

        $this->carparkModel->updateCarpark($id, $name, $price);
        header('Location: index.php?controller=carpark&action=index');
    }
}