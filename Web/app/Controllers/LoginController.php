<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;
use App\Util;
use App\Controller;

/**
 * Used for all the login functionality.
 */
class LoginController extends Controller
{
    /**
     * The User Model for interacting with the database.
     */
    private $userModel;

    /**
     * Creates a new LoginController object.
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->userModel = new UserModel();
    }

    /**
     * Shows the index page with errors if applicable.
     * 
     * @param array $errors Errors if applicable.
     * 
     * @return void
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
     * 
     * @return void
     */
    public function login()
    {
        if (AuthHelper::isLoggedIn() || !isset($this->params['email']) || !isset($this->params['password']))
            exit(header('Location: index.php'));

        $email = $this->params['email'];
        $password = $this->params['password'];
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
     * 
     * @return void
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
     * 
     * @return void
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
     * 
     * @param string $email The email address.
     * @param string $password The plain-text password.
     * 
     * @return void
     */
    private function authenticate($email, $password)
    {
        $user = $this->userModel->getUserByEmailPassword($email, $password);

        if ($user == null) return -1;

        return $user->ID;
    }
}