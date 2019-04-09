<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;
use App\Controller;

/**
 * Used for registration actions.
 */
class RegisterController extends Controller
{
    /**
     * The User Model for interacting with the database.
     */
    private $userModel;

    /**
     * Create a new RegisterController object.
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->userModel = new UserModel();
    }

    /**
     * Show the register index page and errors if applicable.
     * 
     * @param array $errors Any errors to be displayed.
     * 
     * @return void
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
     * 
     * @return void
     */
    public function register()
    {
        if (AuthHelper::isLoggedIn()
            || !isset($this->params['firstName']) 
            || !isset($this->params['lastName'])
            || !isset($this->params['email'])
            || !isset($this->params['password']))
            exit(header('Location: index.php'));
            
        $firstName = filter_var($this->params['firstName'], FILTER_SANITIZE_STRING);
        $lastName = filter_var($this->params['lastName'], FILTER_SANITIZE_STRING);
        $email = filter_var($this->params['email'], FILTER_SANITIZE_EMAIL);
        $password = $this->params['password'];

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
     * 
     * @return void
     */
    public function success()
    {
        $view = new View('Register/success');
        $view->assign('pageTitle', 'Register Success');
        $view->render();
    }
}