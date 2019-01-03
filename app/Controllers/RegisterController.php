<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;

class RegisterController 
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index($errors = null)
    {
        if (AuthHelper::isLoggedIn())
            header('Location: index.php');

        $view = new View('Register/index');
        $view->assign('pageTitle', 'Register');
        $view->assign('errors', $errors);
        $view->render();
    }

    public function register()
    {
        if (isset($_POST['firstName']) 
            AND isset($_POST['lastName'])
            AND isset($_POST['email'])
            AND isset($_POST['password']))
        {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
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
        else 
            header('Location: index.php');
    }

    public function success()
    {
        $view = new View('Register/success');
        $view->assign('pageTitle', 'Register Success');
        $view->render();
    }
}