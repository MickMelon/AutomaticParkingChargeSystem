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
    private $userModel;
    private $vehicleModel;
    private $parkingModel;
    private $carparkModel;

    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->userModel = new UserModel();
        $this->vehicleModel = new VehicleModel();
        $this->parkingModel = new ParkingModel();
        $this->carparkModel = new CarparkModel();
    }

    public function check()
    {
        // Need to check the IP of the client so not just anyone and their nan can do this
        if (isset($this->params['type']) && isset($this->params['reg']) && isset($this->params['carparkid']))
        {
            $reg = $this->params['reg'];
            $type = $this->params['type'];
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

            // Check if the type has been set
            if ($type == 'entry' || $type == 'enter')
            {
                $this->parkingModel->addEntry($reg, $carparkId);

                $json = new Json(array('Message' => 'ENTRY_SUCCESS'));
                $json->execute();
                return;
            }
            else if ($type == 'exit' || $type == 'leave')
            {
                if ($this->parkingModel->isInCarpark($reg))
                {
                    $this->parkingModel->addExit($reg);

                    $parking = $this->parkingModel->getLatestParking($reg);
                    if ($parking == null) { echo 'wtf'; return; }
                    $entryDateTime = $parking->EntryDateTime;

                    // Send the payment email
                    $user = $this->userModel->getUserById($vehicle->UserID);
                    $message = 'You have an outstanding balance for your time parking at our car park.<br />'
                        . '<a href="https://mayar.abertay.ac.uk/~cmp311gc1801/index.php?controller=payment&action=makepayment&reg=' 
                        . $reg . '&entrydatetime=' . $entryDateTime .'">Please click this dodgy link to pay</a><br />'
                        . 'Thanks,<br />'
                        . 'Smart Parking Ltd.';
                    $headers = 'From: payments@smartparkingltd.com' . "\r\n" .
                        'Reply-To: payments@smartparkingltd.com' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                    mail($user->Email, 'Payment for Smart Parking Ltd', $message);

                    $json = new Json(array('Message' => 'EXIT_SUCCESS'));
                    $json->execute();
                    return;
                }
                else
                {
                    $json = new Json(array('Message' => 'PARKING_ENTRY_NOT_FOUND'));
                    $json->execute();
                    return;
                }
            }
            else
            {
                $json = new Json(array('Message' => 'TYPE_NOT_SPECIFIED'));
                $json->execute();
                return;            
            }
        }

        $json = new Json(array('Message' => 'PARAMETERS_MISSING'));
        $json->execute();
    }
}