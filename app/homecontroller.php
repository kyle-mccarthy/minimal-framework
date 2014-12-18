<?php namespace App;

use Framework\Models\Log;
use Framework\Models\User;

class HomeController extends BaseController
{
    /**
     * Handle displaying the home/index page.  Depending on if the user is logged in,
     * it will show the login/register form or information about the user.
     */
    public function getIndex()
    {
        if (isset($_SESSION['username']) && !is_null($_SESSION['username'])) {
            $_SESSION['title'] = "Home";
            $log = new Log($_SESSION['username']);
            $_SESSION['logs'] = $log->getAll();
            $_SESSION['registered'] = $log->getRegistration();
            $user = new User();
            $_SESSION['description'] = $user->getDescription();
            return include(__DIR__ . '/../templates/home.php');
        }
        $this->redirect->requireSSL();
        $_SESSION['title'] = "Login or Register";
        return include(__DIR__ . '/../templates/index.php');
    }
}