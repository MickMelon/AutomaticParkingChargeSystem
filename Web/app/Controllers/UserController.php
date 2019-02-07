<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;
use App\Util;

/**
 * Used for the user details page.
 */
class UserController 
{
    /**
     * The User Model for interacting with the database.
     */
    private $userModel;

    /**
     * Creates a new CustomerController object.
     */
    public function __construct()
    {
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
            || !isset($_POST['firstName'])
            || !isset($_POST['lastName'])
            || !isset($_POST['password'])
            || !isset($_POST['userId']))
            exit(header('Location: index.php'));

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $password = $_POST['password'];
        $userId = $_POST['userId'];

        $this->userModel->updateUser($userId, $firstName, $lastName, $password);
        header('Location: index.php?controller=user&action=show');
    }
}
