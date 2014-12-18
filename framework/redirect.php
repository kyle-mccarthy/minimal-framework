<?php namespace Framework;

class Redirect
{
    /**
     * Once the framework is expanded this will be helpful.   It isn't very modular to have all hard coded page
     * redirect so this lets the developer pass a value and it will automatically redirect them.
     *
     * @param $query
     */
    public function to($query)
    {
        header("Location: index.php?r=" . $query);
    }

    /**
     * The index.php file handles the routing and consequently is required to view the site.  If
     * they try to define a page other than then index redirect them automatically with the query string.
     */
    public function toIndex()
    {
        if (basename($_SERVER['PHP_SELF']) != "index.php") {
            header("Location: index.php?" . $_SERVER['QUERY_STRING']);
        }
    }

    /**
     * If the user is currently not using HTTPS protocol redirect them to the https version
     * of the site.
     */
    public function requireSSL()
    {
        if (!isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "on") {
            header("location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }
    }

    /**
     * If the user is not logged in redirect them to the login page.
     */
    public function requireAuth()
    {
        if (!isset($_SESSION['username']) || is_null($_SESSION['username'])) {
            $this->toAuth();
        }
    }
}