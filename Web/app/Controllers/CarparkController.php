<?php
namespace App\Controllers;

use App\Models\CarparkModel;
use App\Models\ParkingModel;
use App\Helpers\AuthHelper;
use App\View;
use App\Controller;

/**
 * Used for car park pages and actions.
 */
class CarparkController extends Controller
{
    /**
     * The Carpark Model for interacting with the database.
     */
    private $carparkModel;

    /**
     * The Parking Model for interacting with the database.
     */
    private $parkingModel;

    /**
     * Creates a new CarparkController object.
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->carparkModel = new CarparkModel();
        $this->parkingModel = new ParkingModel();
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
     * Shows a single car park by its ID.
     */
    public function show()
    {
        if (!AuthHelper::isAdmin() || !isset($this->params['id']))
            exit(header('Location: index.php'));
            
        $id = $this->params['id'];
        $carpark = $this->carparkModel->getCarparkById($id);
        $logs = $this->parkingModel->getAllForCarpark($id);

        $view = new View('Carpark/show');
        $view->assign('pageTitle', $carpark->Name);
        $view->assign('id', $carpark->ID);
        $view->assign('name', $carpark->Name);
        $view->assign('price', $carpark->Price);
        $view->assign('logs', $logs);
        $view->render();
    }

    /**
     * Shows the update car park page.
     * 
     * @return void
     */
    public function update()
    {
        if (!AuthHelper::isAdmin() || !isset($this->params['id']))
            exit(header('Location: index.php'));

        $id = $this->params['id'];
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
        if (!AuthHelper::isAdmin() || !isset($this->params['carparkId']))
            exit(header('Location: index.php'));

        $id = $this->params['carparkId'];
        $name = $this->params['name'];
        $price = $this->params['price'];

        $this->carparkModel->updateCarpark($id, $name, $price);
        header('Location: index.php?controller=carpark&action=index');
    }
}