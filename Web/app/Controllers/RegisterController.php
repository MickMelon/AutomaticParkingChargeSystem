<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;

class RegisterController 
{
    /**
     * The User Model for interacting with the database.
     */
    private $userModel;

    /**
     * Create a new RegisterController object.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Show the register index page and errors if applicable.
     * 
     * @param array $errors Any errors to be displayed.
     */
    public function index($errors = null)
    {
        if (AuthHelper::isLoggedIn())
            exit(header('Location: index.php'));

        $view = new View('Register/index');
        $view->assign('pageTitle', 'Register');
        $view->assign('errors', $errors);
        $view->render();
    }

    /**
     * Show the register page.
     */
    public function register()
    {
        if (!AuthHelper::isLoggedIn()
            || !isset($_POST['firstName']) 
            || !isset($_POST['lastName'])
            || !isset($_POST['email'])
            || !isset($_POST['password']))
            exit(header('Location: index.php'));
            
        $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
        $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

        $existingUser = $this->userModel->getUserByEmail($email);
        if ($existingUser != null)
        {
            $errors[] = 'An account with that email address already exists.';
            $this->index($errors);
        }
        else 
        {
            $this->userModel->createUser($firstName, $lastName, $email, $password);
            header('Location: index.php?controller=register&action=success');
        }
    }

    /**
     * Show the success page.
     */
    public function success()
    {
        $view = new View('Register/success');
        $view->assign('pageTitle', 'Register Success');
        $view->render();
    }
}