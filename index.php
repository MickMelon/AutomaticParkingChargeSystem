<?php
/* 
* This file is called with every request to the website
* it basically just starts everything up and calls the 
* router to display the requested page or carry out 
* the requested action.
*/

session_start();
require_once('vendor/autoload.php');

use App\Config;
use App\Router;
use App\Database;

if (Config::DISPLAY_ERRORS)
{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// The router will pretty much start the app.
$router = new Router();
$router->start();
