<?php 
namespace App\Controllers;

use App\Models\VehicleModel;
use App\Helpers\AuthHelper;
use App\Config;
use App\View;

/**
 * Used for all the vehicle actions.
 */
class VehicleController 
{
    /**
     * The Vehicle Model for interacting with the database.
     */
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
     * 
     * @param array $errors Any errors to be displayed.
     * 
     * @return void
     */
    public function index($errors = null)
    {
        if (!AuthHelper::isLoggedIn())
            exit(header('Location: index.php'));

        $vehicles = $this->vehicleModel->getAllVehiclesForUser($_SESSION['id']);

        $view = new View('Vehicle/index');
        $view->assign('pageTitle', 'Your Vehicles');
        $view->assign('errors', $errors);
        $view->assign('vehicles', $vehicles);
        $view->render();
    }

    /**
     * Add a new vehicle.
     * 
     * @return void
     */
    public function add()
    {
        if (!AuthHelper::isLoggedIn() || !isset($_POST['reg']))
            exit(header('Location: index.php'));
        
        $reg = filter_var($_POST['reg'], FILTER_SANITIZE_STRING);
        $userId = $_SESSION['id'];

        $existingVehicle = $this->vehicleModel->getVehicle($reg);
        if ($existingVehicle != null)
        {
            $errors[] = 'That vehicle is already registered to an account.';
            $this->index($errors);
            return;
        }

        $this->vehicleModel->createVehicle($reg, $userId);
        header('Location: index.php?controller=vehicle&action=index');
    }

    /** 
     * Remove a vehicle.
     * 
     * @return void
     */
    public function remove()
    {
        if (!AuthHelper::isLoggedIn() || !isset($_POST['reg']))
            exit(header('Location: index.php'));

        $reg = filter_var($_GET['reg'], FILTER_SANITIZE_STRING);
        $userId = $_SESSION['id'];
        $vehicle = $this->vehicleModel->getVehicle($reg);

        if ($vehicle == null || $vehicle->UserID != $userId)
        {
            $errors[] = 'You cannot remove that vehicle for some reason.';
            $this->index($errors);
            return;
        }
        $this->vehicleModel->deleteVehicle($reg);
        header('Location: index.php?controller=vehicle&action=index');            
    }

    /**
     * Called when the purchase permit button has been clicked for a vehicle.
     * 
     * @return void
     */
    public function purchasePermit()
    {
        if (!AuthHelper::isLoggedIn() || !isset($_POST['reg']))
            exit(header('Location: index.php'));

        $reg = filter_var($_GET['reg'], FILTER_SANITIZE_STRING);
        $userId = $_SESSION['id'];
        $vehicle = $this->vehicleModel->getVehicle($reg);

        if ($vehicle == null || $vehicle->UserID != $userId)
        {
            $errors[] = 'You cannot purchase a permit for that vehicle.';
            $this->index($errors);
            return;
        }

        if ($vehicle->HasPermit)
        {
            $errors[] = 'You already have a permit for that vehicle.';
            $this->index($errors);
            return;
        }
        
        $view = new View('Vehicle/purchase_permit');
        $view->assign('pageTitle', 'Stripe Payment');
        $view->assign('amount', Config::PERMIT_PRICE_POUNDS * 100);
        $view->assign('publicKey', Config::STRIPE_PUBLIC_KEY);
        $view->assign('reg', $vehicle->Reg);
        $view->render();        
    }

    /**
     * Called when a payment has been made successfully.
     * 
     * @return void
     */
    public function submitPermitPayment()
    {
        if (!isset($_POST['reg']))
            exit(header('Location: index.php'));
        
        $reg = $_POST['reg'];

        \Stripe\Stripe::setApiKey(Config::STRIPE_SECRET_KEY);
        $token = $_POST['stripeToken'];

        $charge = \Stripe\Charge::create(
                ['amount' => Config::PERMIT_PRICE_POUNDS * 100,
                'currency' => 'gbp',
                'source' => $token,
                'description' => 'Season permit payment']
            );

        $this->vehicleModel->addPermit($reg);
        header('Location: index.php?controller=vehicle&action=index');   
    }
}