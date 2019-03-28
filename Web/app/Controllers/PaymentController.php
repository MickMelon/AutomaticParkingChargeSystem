<?php
namespace App\Controllers;

use App\Models\ParkingModel;
use App\Models\VehicleModel;
use App\Models\ConfigModel;
use App\Config;
use App\Helpers\AuthHelper;
use App\View;
use App\Controller;

/**
 * Used for controlling the payments.
 */
class PaymentController extends Controller
{
    /**
     * The ParkingModel
     */
    private $parkingModel;

    /**
     * The VehicleModel
     */
    private $vehicleModel;

    /**
     * The ConfigModel
     */
    private $configModel;

    /**
     * Creates a new instance of the PaymentController class.
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->parkingModel = new ParkingModel();
        $this->vehicleModel = new VehicleModel();
        $this->configModel = new ConfigModel();
    }

    /**
     * Shows the make payment page.
     */
    public function makePayment()
    {
        if (AuthHelper::isLoggedIn())
        {
            if (isset($this->params['reg']) &&
                isset($this->params['entrydatetime']))
            {
                $reg = $this->params['reg'];
                $entryDateTime = $this->params['entrydatetime'];

                // Check if the vehicle reg is valid
                $vehicle = $this->vehicleModel->getVehicle($reg);
                if ($vehicle == null)
                {
                    echo 'Vehicle reg invalid';
                    return;
                }

                // Check if the logged in user is associated with the vehicle
                if ($vehicle->UserID != $_SESSION['id'])
                {
                    echo 'Not assocaited with vehicle';
                    return;
                }

                // Check if the vehicle has a season permit
                if ($vehicle->HasPermit == 1)
                {
                    echo 'Has permit';
                    return;
                }

                // Check that there is a parking log for the vehicle
                $parking = $this->parkingModel->getSingle($reg, $entryDateTime);
                if ($parking == null)
                {
                    echo 'No parking log';
                    return;
                }

                // Check that the vehicle has left the car park
                if ($parking->ExitDateTime == '0000-00-00 00:00:00')
                {
                    echo 'Vehicle has not left car park';
                    return;
                }

                // Check that it hasn't already been paid
                if ($parking->Paid == 1)
                {
                    echo 'Parking already paid for';
                    return;
                }

                $hourlyRate = $this->configModel->getValue(ConfigModel::HOURLY_RATE);
                $cost = $this->parkingModel->calculateCosts($reg, $entryDateTime, $hourlyRate);

                // Show the payment form
                $view = new View('Payment/make_payment');
                $view->assign('pageTitle', 'Make Payment');
                $view->assign('amount', $cost * 100);
                $view->assign('publicKey', Config::STRIPE_PUBLIC_KEY);
                $view->assign('reg', $reg);
                $view->assign('entryDateTime', $entryDateTime);
                $view->render();
            }
        }
    }

    /**
     * Called when the payment has been submitted.
     */
    public function submitPayment()
    {
        if (AuthHelper::isLoggedIn())
        {
            if (isset($this->params['reg']) &&
                isset($this->params['entrydatetime']) &&
                isset($this->params['cost']))
            {
                $reg = $this->params['reg'];
                $entryDateTime = $this->params['entrydatetime'];
                $cost = $this->params['cost'];

                \Stripe\Stripe::setApiKey(Config::STRIPE_SECRET_KEY);
                $token = $this->params['stripeToken'];

                $charge = \Stripe\Charge::create(
                    ['amount' => $cost,
                     'currency' => 'gbp',
                     'source' => $token,
                     'description' => 'Parking payment for ' . $reg . ' at ' . $entryDateTime]
                );

                $this->parkingModel->setPaid($reg, $entryDateTime);
                header('Location: index.php?controller=vehicle&action=index');
            }
        }
    }
}