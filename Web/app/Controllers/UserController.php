<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;
use App\Util;
use App\Controller;

/**
 * Used for the user details page.
 */
class UserController extends Controller
{
    /**
     * The User Model for interacting with the database.
     */
    private $userModel;

    /**
     * Creates a new CustomerController object.
     */
    public function __construct(array $params)
    {
        parent::__construct($params);
        $this->userModel = new UserModel();
    }

    /**
     * Shows the user details page.
     * 
     * @return void
     */
    public function show()
    {
        if (!AuthHelper::isLoggedIn())
            exit(header('Location: index.php'));
        
        $userId = $_SESSION['id'];
        $user = $this->userModel->getUserById($userId);

        $view = new View('User/show');
        $view->assign('pageTitle', 'Your Details');
        $view->assign('user', $user);
        $view->render();
    }

    /**
     * Shows the update user details page.
     * 
     * @return void
     */
    public function update()
    {
        if (!AuthHelper::isLoggedIn())
            exit(header('Location: index.php'));
        
        $userId = $_SESSION['id'];
        $user = $this->userModel->getUserById($userId);

        $view = new View('User/update');
        $view->assign('pageTitle', 'Update Your Details');
        $view->assign('user', $user);
        $view->render();
    }

    /**
     * Called when the update user form has been submitted.
     * 
     * @return void
     */
    public function submitUpdate()
    {
        if (!AuthHelper::isLoggedIn()
            || !isset($this->params['firstName'])
            || !isset($this->params['lastName'])
            || !isset($this->params['password'])
            || !isset($this->params['userId']))
            exit(header('Location: index.php'));

        $firstName = $this->params['firstName'];
        $lastName = $this->params['lastName'];
        $password = $this->params['password'];
        $userId = $this->params['userId'];

        $this->userModel->updateUser($userId, $firstName, $lastName, $password);
        header('Location: index.php?controller=user&action=show');
    }
}
