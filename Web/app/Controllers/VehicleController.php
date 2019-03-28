<?php 
namespace App\Controllers;

use App\Models\VehicleModel;
use App\Models\ConfigModel;
use App\Helpers\AuthHelper;
use App\Config;
use App\View;
use App\Controller;

/**
 * Used for all the vehicle actions.
 */
class VehicleController extends Controller
{
    /**
     * The Vehicle Model for interacting with the database.
     */
    private $vehicleModel;
    private $configModel;

    /**
     * Create a new VehicleController object.
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->vehicleModel = new VehicleModel();
        $this->configModel = new ConfigModel();
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
        if (!AuthHelper::isLoggedIn() || !isset($this->params['reg']))
            exit(header('Location: index.php'));
        
        $reg = filter_var($this->params['reg'], FILTER_SANITIZE_STRING);
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
        if (!AuthHelper::isLoggedIn() || !isset($this->params['reg']))
            exit(header('Location: index.php'));

        $reg = filter_var($this->params['reg'], FILTER_SANITIZE_STRING);
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
        if (!AuthHelper::isLoggedIn() || !isset($this->params['reg']))
            exit(header('Location: index.php'));

        $reg = filter_var($this->params['reg'], FILTER_SANITIZE_STRING);
        $userId = $_SESSION['id'];
        $vehicle = $this->vehicleModel->getVehicle($reg);

        // Make sure there is a vehicle for that reg and that it belongs to the user
        if ($vehicle == null || $vehicle->UserID != $userId)
        {
            $errors[] = 'You cannot purchase a permit for that vehicle.';
            $this->index($errors);
            return;
        }

        // Check if the vehicle already has a permit
        if ($vehicle->HasPermit)
        {
            $errors[] = 'You already have a permit for that vehicle.';
            $this->index($errors);
            return;
        }

        $permitPrice = $this->configModel->getConfigValue(ConfigModel::PERMIT_PRICE);
        
        $view = new View('Vehicle/purchase_permit');
        $view->assign('pageTitle', 'Stripe Payment');
        $view->assign('amount', $permitPrice * 100); // times by 100 because stripe works in pence
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
        if (!isset($this->params['reg']))
            exit(header('Location: index.php'));
        
        $reg = $this->params['reg'];

        \Stripe\Stripe::setApiKey(Config::STRIPE_SECRET_KEY);
        $token = $this->params['stripeToken'];

        $permitPrice = $this->configModel->getConfigValue(ConfigModel::PERMIT_PRICE);

        $charge = \Stripe\Charge::create(
                ['amount' => $permitPrice * 100,
                'currency' => 'gbp',
                'source' => $token,
                'description' => 'Season permit payment']
            );

        $this->vehicleModel->addPermit($reg);
        header('Location: index.php?controller=vehicle&action=index');   
    }
}