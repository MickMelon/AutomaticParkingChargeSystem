<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\VehicleModel;
use App\Models\ParkingModel;
use App\Models\CarparkModel;
use App\Helpers\AuthHelper;
use App\Json;

/**
 * The Raspberry Pi will use this controller for communications.
 */
class ApiController
{
    private $userModel;
    private $vehicleModel;
    private $parkingModel;
    private $carparkModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->vehicleModel = new VehicleModel();
        $this->parkingModel = new ParkingModel();
        $this->carparkModel = new CarparkModel();
    }

    public function check()
    {
        // Need to check the IP of the client so not just anyone and their nan can do this
        if (isset($_GET['type']) && isset($_GET['reg']) && isset($_GET['carparkid']))
        {
            $reg = $_GET['reg'];
            $type = $_GET['type'];
            $carparkId = $_GET['carparkid'];

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

                // Send the payment email
                

                $json = new Json(array('Message' => 'ENTRY_SUCCESS'));
                $json->execute();
                return;
            }
            else if ($type == 'exit' || $type == 'leave')
            {
                if ($this->parkingModel->isInCarpark($reg))
                {
                    $this->parkingModel->addExit($reg);

                    // Send the bill


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