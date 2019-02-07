<?php 
namespace App\Controllers;

use App\Models\UserModel;
use App\Helpers\AuthHelper;
use App\View;
use App\Util;

class UserController 
{
    private $userModel;

    /**
     * Creates a new CustomerController object.
     */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

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
