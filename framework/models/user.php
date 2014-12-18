<?php namespace Framework\Models;

class User extends BaseModel
{
    public $username;
    private $password_hash;
    private $salt;

    /**
     * Attempt to log the user in.  If the user enters the wrong username/password combo
     * return false, if it returns the correct info return true.
     * @param $username
     * @param $password
     * @return null|object|resource
     */
    public function login($username, $password)
    {
        pg_prepare($this->db, "login", 'SELECT * FROM lab8.authentication ' .
            'WHERE username = $1');
        $result = pg_execute($this->db, "login", array($username));
        // the user can't be found
        if (is_bool($result)) {
            return false;
        }
        $result = pg_fetch_object($result);
        $password = $this->password($password, $result->salt);
        if (strcmp($password['password_hash'], $result->password_hash) == 0) {
            $_SESSION['username'] = $username;
            $log = new Log($username);
            $log->login();
            return true;
        }
        // they entered the wrong password
        return false;
    }

    /**
     * Logout the user by killing the session
     */
    public function logout()
    {
        if (isset($_SESSION)) {
            session_destroy();
        }
    }

    /**
     * Register a user.  Try to add the user to the DB, if the result is a boolean
     * that means the data wasn't valid and the user hasn't been inserted.  Otherwise
     * return a user object.
     * @param $username
     * @param $password
     * @return null|object
     */
    public function register($username, $password)
    {
        // insert the user into the user_info section
        pg_prepare($this->db, "user_info", 'INSERT INTO lab8.user_info ' .
            '(username) values($1)');
        $result = pg_execute($this->db, "user_info", array($username));
        // insert the user into authentication
        pg_prepare($this->db, "register", 'INSERT INTO lab8.authentication ' .
            '(username, password_hash, salt) values($1, $2, $3)');
        // hash the password
        $hashedPassword = $this->password($password);
        $result = pg_execute($this->db, "register", array($username,
            $hashedPassword["password_hash"], $hashedPassword["salt"]));
        // if the result is a boolean it means the data wasn't inserted correctly
        if (is_bool($result)) {
            return false;
        }
        $this->login($username, $password);
        $log = new Log($username);
        $log->registration();
        return true;
    }

    /**
     * Update the user account and user info for the account.  This has a built in
     * password update, so it can be included in the $_POST data.
     * @param $username
     * @param $post
     */
    public function update($username, $post)
    {

        // if they are trying to set a new password encrypt it and save it
        if (strlen($post['password'] > 0)) {
            pg_prepare($this->db, "fetchuser", 'SELECT * FROM lab8.authentication ' .
                'WHERE username = $1');
            $result = pg_execute($this->db, "fetchuser", array($username));
            $result = pg_fetch_object($result);
            $post['password'] = $this->password($post['password'], $result->salt);
            pg_prepare($this->db, "update_user", "UPDATE lab8.authentication "
                . "SET (password_hash) = $1 WHERE username = $2");
            pg_execute($this->db, "update_user", array($post["password"], $username));
        }
        // update the user info description
        pg_prepare($this->db, "info", "UPDATE lab8.user_info "
            . "SET description = $1 WHERE username = $2");
        pg_execute($this->db, "info", array($post["description"], $username));
    }

    /**
     * Get the description for the current user.  This info is stored in a different
     * table so it isn't automatically queried when the user logs in.  It's also
     * helpful when updating the $_SESSION['description']
     * @return $user->description
     */
    public function getDescription()
    {
        if (!isset($_SESSION['username']) || is_null($_SESSION['username'])) {
            return null;
        }
        $username = $_SESSION['username'];
        pg_prepare($this->db, "get_description", "SELECT * FROM lab8.user_info "
            . "WHERE username = $1");
        $result = pg_execute($this->db, "get_description", array($username));
        $result = pg_fetch_object($result);
        return $result->description;
    }

    /**
     * Accept a password and an optional salt.  If the salt is not provided generate
     * a new password.  Hash the password using the algorithm and then return an
     * array containing the fully hashed password and the salt.
     * @param $password
     * @param null $salt
     * @return array
     */
    private function password($password, $salt = null)
    {
        // if there isn't a slat provided that means it's a new user so create a sakt
        if (is_null($salt)) {
            $salt = sha1(rand());
        }
        // hash the password and then concat them and hash again
        $password = sha1($password);
        return array("password_hash" => sha1($password . $salt), "salt" => $salt);
    }
}