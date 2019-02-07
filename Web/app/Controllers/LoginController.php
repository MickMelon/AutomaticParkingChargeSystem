<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;
use App\Util;

class LoginController 
{
    private $userModel;

    /**
     * Creates a new LoginController object.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Shows the index page with errors if applicable.
     */
    public function index($errors = null)
    {
        if (AuthHelper::isLoggedIn())
            exit(header('Location: index.php'));

        $view = new View('Login/index');
        $view->assign('pageTitle', 'Login');
        $view->assign('errors', $errors);
        $view->render();
    }

    /**
     * Processes a login request.
     */
    public function login()
    {
        if (AuthHelper::isLoggedIn() || !isset($_POST['email']) || !isset($_POST['password']))
            exit(header('Location: index.php'));

        $email = $_POST['email'];
        $password = $_POST['password'];
        $result = $this->authenticate($email, $password);

        if ($result > 0)
        {
            $_SESSION['id'] = $result;
            $_SESSION['token'] = rand(100000, 999999);

            header('Location: index.php?controller=login&action=success');
        }
        else 
        {
            $errors[] = 'Incorrect email address or password.';
            $this->index($errors);
        }
    }

    /**
     * Processes a logout request.
     */
    public function logout()
    {
        if (!AuthHelper::isLoggedIn())
            exit(header('Location: index.php'));

        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();

        header('Location: index.php?controller=login&action=success');
    }

    /**
     * Shows the login success page.
     */
    public function success()
    {
        $view = new View('Login/success');
        $view->assign('pageTitle', 'Login Success');
        $view->render();
    }

    /**
     * Check whether the username and password match an 
     * account.
     */
    private function authenticate($email, $password)
    {
        $user = $this->userModel->getUserByEmailPassword($email, $password);

        if ($user == null) return -1;

        return $user->ID;
    }
}