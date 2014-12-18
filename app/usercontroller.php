<?php namespace App;

use Framework\Models\User;

class UserController extends BaseController
{
    /**
     * Attempt to register the user.  If the user is successfully created, the model will log
     * them in and then redirect them to the home page.
     */
    public function postRegister()
    {
        $this->redirect->requireSSL();
        $user = new User();
        unset($_SESSION['error']);
        if ($user->register($_POST['username'], $_POST['password'])) {
            return $this->redirect->to("home");
        }
        // invalid authentication
        $_SESSION['error'] = array(
            'message' => 'Invalid username or password.  The username may already be in' .
                'use, try another one.',
            'for' => 'register-form',
            'variables' => array(
                'username' => $_POST['username'],
            ),
        );
        $this->redirect->to("index");
    }

    /**
     * Attempt to log the user in.  If the user credentials are valid redirect them
     * to the home page.  If they aren't set a session variable describing the
     * issue and display it on the home page.
     */
    public function postLogin()
    {
        $this->redirect->requireSSL();
        $user = new User();
        unset($_SESSION['error']);
        // try to log the user in
        if ($user->login($_POST['username'], $_POST['password'])) {
            return $this->redirect->to("home");
        }
        // invalid authentication
        $_SESSION['error'] = array(
            'message' => 'Invalid username/password combination',
            'for' => 'login-form',
            'variables' => array(
                'username' => $_POST['username'],
            ),
        );
        $this->redirect->to("index");
    }

    /**
     * Handle displaying the login form by itself.
     */
    public function getLogin()
    {
        $_SESSION['title'] = "Login";
        return include(__DIR__ . '/../templates/login.php');
    }

    /**
     * Handle displaying the register form by itself.
     */
    public function getRegister()
    {
        $_SESSION['title'] = "Register";
        return include(__DIR__ . '/../templates/register.php');
    }

    /**
     * Handle showing the update form.  Get the username and description also and pass
     * that to the template.
     */
    public function getUpdate()
    {
        $this->redirect->requireAuth();
        $_SESSION['title'] = "Update";
        $user = new User();
        $_SESSION['description'] = $user->getDescription();
        return include(__DIR__ . '/../templates/update.php');
    }

    /**
     * Handle updating the user with the post data and then redirect to the home page
     */
    public function postUpdate()
    {
        $this->redirect->requireAuth();
        $user = new User();
        $user->update($_SESSION['username'], $_POST);
        $this->redirect->to("home");
    }

    /**
     * Logout the user by destroying the session and then redirect to the index page
     */
    public function getLogout()
    {
        session_destroy();
        $this->redirect->to("index");
    }
}