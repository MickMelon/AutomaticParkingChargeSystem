<?php
namespace App;

use App\Controllers;

/**
 * Used to start the application and to do actions on controllers.
 */
class Router
{
    /**
     * Gets the specified controller and action and acts on it to 
     * effectively start the app.
     * 
     * Set the controller and action depending on the parameters
     * that are set.
     * e.g. index.php?controller=articles&action=index
     * would set $controller to articles and $action to index
     * 
     * @return void
     */
    public function start()
    {
        $controller = isset($_GET['controller']) ? strtolower($_GET['controller']) : 'page';
        $action = isset($_GET['action']) ? strtolower($_GET['action']) : 'home';

        $this->call($controller, $action);         
    }

    /**
     * Calls an action on the specified controller.
     * 
     * @param string $controller The controller.
     * @param string $action The action to be made on the controller.
     * 
     * @return void
     */
    public function call($controller, $action)
    {
        // Check to see if the class and method exist, if they do, call it.
        $className = 'App\Controllers\\' . ucfirst($controller) . 'Controller';
        if (class_exists($className, true))  
        {
            $controllerClass = new $className();
            if (method_exists($controllerClass, $action))
            {
                $controllerClass->{ $action }();
                return;
            }    
        }

        // Call the index of the page controller if the specified 
        // controller or action were not found.
        $pageController = new Controllers\PageController();
        $pageController->error();    
    }
}
