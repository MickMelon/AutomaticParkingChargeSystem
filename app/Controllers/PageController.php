<?php 
namespace App\Controllers;

use App\View;

class PageController
{
    /**
     * Displays the home page.
     */
    public function home()
    {
        $view = new View('Pages/home');
        $view->render();
    }

    /**
     * Displays the error page.
     */
    public function error()
    {
        $view = new View('Pages/error');
        $view->render();
    }
}