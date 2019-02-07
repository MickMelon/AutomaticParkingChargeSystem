<?php
namespace App\Controllers;

use App\Models\CarparkModel;
use App\Helpers\AuthHelper;
use App\View;

/**
 * Used for car park pages and actions.
 */
class CarparkController
{
    /**
     * The Carpark Model for interacting with the database.
     */
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
     * 
     * @return void
     */
    public function index()
    {
        if (!AuthHelper::isAdmin())
            exit(header('Location: index.php'));

        $carparks = $this->carparkModel->getAllCarparks();

        $view = new View('Carpark/index');
        $view->assign('pageTitle', 'Car Parks');
        $view->assign('carparks', $carparks);
        $view->render();
    }

    /**
     * Shows the update car park page.
     * 
     * @return void
     */
    public function update()
    {
        if (!AuthHelper::isAdmin() || !isset($_GET['id']))
            exit(header('Location: index.php'));

        $id = $_GET['id'];
        $carpark = $this->carparkModel->getCarparkById($id);

        $view = new View('Carpark/update');
        $view->assign('pageTitle', 'Update Car Park');
        $view->assign('carpark', $carpark);
        $view->render();
    }

    /**
     * Called when the update car park form has been submitted.
     * 
     * @return void
     */
    public function submitUpdate()
    {
        if (!AuthHelper::isAdmin() || !isset($_POST['carparkId']))
            exit(header('Location: index.php'));

        $id = $_POST['carparkId'];
        $name = $_POST['name'];
        $price = $_POST['price'];

        $this->carparkModel->updateCarpark($id, $name, $price);
        header('Location: index.php?controller=carpark&action=index');
    }
}