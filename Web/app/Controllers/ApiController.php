<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\VehicleModel;
use App\Models\ParkingModel;
use App\Models\CarparkModel;
use App\Helpers\AuthHelper;
use App\Json;
use App\Controller;

/**
 * The Raspberry Pi will use this controller for communications.
 */
class ApiController extends Controller
{
    /**
     * The UserModel
     */
    private $userModel;

    /**
     * The VehicleModel
     */
    private $vehicleModel;

    /**
     * The ParkingModel
     */
    private $parkingModel;

    /**
     * The CarparkModel
     */
    private $carparkModel;

    /**
     * Creates a new instance of the ApiController class.
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->userModel = new UserModel();
        $this->vehicleModel = new VehicleModel();
        $this->parkingModel = new ParkingModel();
        $this->carparkModel = new CarparkModel();
    }

    /**
     * Called from the Raspberry Pi. It will check whether a vehicle should be allowed to enter
     * or exit the car park and return the appropriate result.
     */
    public function check()
    {
        // Need to check the IP of the client so not just anyone and their nan can do this
        if (isset($this->params['reg']) && isset($this->params['carparkid']))
        {
            $reg = $this->params['reg'];
            $carparkId = $this->params['carparkid'];

            // Check the carpark actually exists
            $carpark = $this->carparkModel->getCarparkById($carparkId);
            if ($carpark == null)
            {
                // Return error json;
                $json = new Json(array('Message' => 'CARPARK_NOT_FOUND'));
                $json->execute();
                return;
            }

            // Check the vehicle exists
            $vehicle = $this->vehicleModel->getVehicle($reg);
            if ($vehicle == null)
            {
                $json = new Json(array('Message' => 'VEHICLE_NOT_FOUND'));
                $json->execute();
                return;
            }

            // Check if the vehicle is already in the car park,
            // this will tell us that the vehicle wants to leave
            if ($this->parkingModel->isInCarpark($reg))
            {
                $this->parkingModel->addExit($reg);

                $parking = $this->parkingModel->getLatestParking($reg);
                $entryDateTime = $parking->EntryDateTime;

                $this->sendPaymentEmail($vehicle->UserID, $reg, $entryDateTime);

                $json = new Json(array('Message' => 'EXIT_SUCCESS'));
                $json->execute();
                return;
            }
            // If not already in car park, then the vehicle is trying to enter
            else
            {
                $this->parkingModel->addEntry($reg, $carparkId);

                $json = new Json(array('Message' => 'ENTRY_SUCCESS'));
                $json->execute();
                return;
            }
        }

        $json = new Json(array('Message' => 'PARAMETERS_MISSING'));
        $json->execute();
    }

    public function sendPaymentEmail($userId, $reg, $entryDateTime)
    {
        // Send the payment email
        $user = $this->userModel->getUserById($userId);
        $message = 'You have an outstanding balance for your time parking at our car park.<br />'
            . '<a href="https://mayar.abertay.ac.uk/~cmp311gc1801/index.php?controller=payment&action=makepayment&reg=' 
            . $reg . '&entrydatetime=' . $entryDateTime .'">Please click this link to pay</a><br />'
            . 'Thanks,<br />'
            . 'Smart Parking Ltd.';
        $headers = 'From: payments@smartparkingltd.com' . "\r\n" .
            'Reply-To: payments@smartparkingltd.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($user->Email, 'Payment for Smart Parking Ltd', $message);
    }
}