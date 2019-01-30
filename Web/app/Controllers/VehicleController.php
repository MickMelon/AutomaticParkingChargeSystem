<?php 
namespace App\Controllers;

use App\Models\VehicleModel;
use App\Helpers\AuthHelper;
use App\View;

class VehicleController 
{
    private $vehicleModel;

    /**
     * Create a new VehicleController object.
     */
    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
    }

    /**
     * Show the vehicles index page.
     */
    public function index($errors = null)
    {
        if (!AuthHelper::isLoggedIn())
            header('Location: index.php');

        $vehicles = $this->vehicleModel->getAllVehiclesForUser($_SESSION['id']);

        $view = new View('Vehicle/index');
        $view->assign('pageTitle', 'Your Vehicles');
        $view->assign('errors', $errors);
        $view->assign('vehicles', $vehicles);
        $view->render();
    }

    /**
     * Add a new vehicle.
     */
    public function add()
    {
        if (AuthHelper::isLoggedIn() && isset($_POST['reg']))
        {
            $reg = filter_var($_POST['reg'], FILTER_SANITIZE_STRING);
            $userId = $_SESSION['id'];

            $existingVehicle = $this->vehicleModel->getVehicle($reg);
            if ($existingVehicle != null)
            {
                $errors[] = 'That vehicle is already registered to an account.';
                $this->index($errors);
            }
            else 
            {
                $this->vehicleModel->createVehicle($reg, $userId);
                header('Location: index.php?controller=vehicle&action=index');
            }        
        }
        else 
            header('Location: index.php');
    }

    /** 
     * Remove a vehicle.
     */
    public function remove()
    {
        if (AuthHelper::isLoggedIn() && isset($_GET['reg']))
        {
            $reg = filter_var($_GET['reg'], FILTER_SANITIZE_STRING);
            $userId = $_SESSION['id'];
            $vehicle = $this->vehicleModel->getVehicle($reg);

            if ($vehicle == null || $vehicle->UserID != $userId)
            {
                $errors[] = 'You cannot remove that vehicle for some reason.';
                $this->index($errors);
            }
            else 
            {
                $this->vehicleModel->deleteVehicle($reg);
                header('Location: index.php?controller=vehicle&action=index');
            }
        } 
        else 
            header('Location: index.php');
    }
}