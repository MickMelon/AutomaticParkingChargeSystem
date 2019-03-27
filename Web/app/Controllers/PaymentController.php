<?php
namespace App\Controllers;

use App\Models\ParkingModel;
use App\Models\VehicleModel;
use App\Config;
use App\Helpers\AuthHelper;
use App\View;

class PaymentController
{
    private $parkingModel;
    private $vehicleModel;

    public function __construct()
    {
        $this->parkingModel = new ParkingModel();
        $this->vehicleModel = new VehicleModel();
    }

    public function makePayment()
    {
        if (AuthHelper::isLoggedIn())
        {
            if (isset($_GET['reg']) &&
                isset($_GET['entrydatetime']))
            {
                $reg = $_GET['reg'];
                $entryDateTime = $_GET['entrydatetime'];

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

                $cost = $this->parkingModel->calculateCosts($reg, $entryDateTime);

                // Show the payment form
                $view = new View('Payment/make_payment');
                $view->assign('pageTitle', 'Make Payment');
                $view->assign('amount', $cost * 100);
                $view->assign('publicKey', Config::STRIPE_PUBLIC_KEY);
                $view->assign('reg', $reg);
                $view->assign('entryDateTime', $entryDateTime);
                $view->render();
            } else echo 'parameters not set';
        } else echo 'not logged in';
    }

    public function submitPayment()
    {
        if (AuthHelper::isLoggedIn())
        {
            if (isset($_POST['reg']) &&
                isset($_POST['entrydatetime']) &&
                isset($_POST['cost']))
            {
                $reg = $_POST['reg'];
                $entryDateTime = $_POST['entrydatetime'];
                $cost = $_POST['cost'];

                \Stripe\Stripe::setApiKey(Config::STRIPE_SECRET_KEY);
                $token = $_POST['stripeToken'];

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