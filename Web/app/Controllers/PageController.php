<?php 
namespace App\Controllers;

use App\View;
use App\Controller;

/**
 * Used for displaying basic pages that don't quite fit in other controllers.
 */
class PageController extends Controller
{
    public function __construct(array $params)
    {
        parent::__construct($params);
    }
    
    /**
     * Displays the home page.
     * 
     * @return void
     */
    public function home()
    {
        $view = new View('Pages/home');
        $view->assign('pageTitle', 'Home');
        $view->render();
    }

    /**
     * Displays the error page.
     * 
     * @return void
     */
    public function error()
    {
        $view = new View('Pages/error');
        $view->render();
    }
}