<?php namespace Framework\Models;

class Log extends BaseModel
{
    public $username;
    public $ip;
    public $action;

    /**
     * Automatically set the ip address and the username.
     * @param $username
     */
    public function __construct($username)
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->username = $username;
        parent::__construct();
    }

    /**
     * Set the action for the new log.  Then save the object.
     */
    public function registration()
    {
        $this->action = "registered";
        $this->save();
    }

    /**
     * Set the action for the new log.  Then save the object.
     */
    public function login()
    {
        $this->action = "authenticated";
        $this->save();
    }

    /**
     * Set the action for the new log.  Then save the object.
     */
    public function update()
    {
        $this->action = "updated";
        $this->save();
    }

    /**
     * Save the user.
     */
    private function save()
    {
        // insert the user into the user_info section
        pg_prepare($this->db, "log", 'INSERT INTO lab8.log ' .
            '(username, ip_address, action) values($1, $2, $3)');
        pg_execute($this->db, "log",
            array($this->username, $this->ip, $this->action));
    }

    /**
     * Get all of the logs for the current user.
     * @return resource
     */
    public function getAll()
    {
        pg_prepare($this->db, "all_logs", 'SELECT * FROM lab8.log ' .
            'WHERE username = $1');
        $result = pg_execute($this->db, "all_logs", array($this->username));
        return $result;
    }

    /**
     * Get the log for when the user originally registered their account.
     * @return object
     */
    public function getRegistration()
    {
        pg_prepare($this->db, "logs", 'SELECT * FROM lab8.log ' .
            'WHERE username = $1 AND action = \'registered\'');
        $result = pg_execute($this->db, "logs", array($this->username));
        return pg_fetch_object($result);
    }
}