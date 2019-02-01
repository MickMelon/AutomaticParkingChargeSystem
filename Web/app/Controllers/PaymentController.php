<?php 
namespace App\Controllers;

use App\Helpers\AuthHelper;
use App\Config;
use App\View;

class PaymentController 
{
    private $vehicleModel;

    /**
     * Create a new VehicleController object.
     */
    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();
    }

    public function stripe()
    {
        $view = new View('Payment/stripe');
        $view->assign('pageTitle', 'Stripe Payment');
        $view->assign('amount', 1000);
        $view->assign('publicKey', Config::STRIPE_PUBLIC_KEY);
        $view->render();
    }

}
