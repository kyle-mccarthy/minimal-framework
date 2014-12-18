<?php namespace Framework;

/**
 * Class DB
 * Handle the database connection for the application.  This will be included
 * for use with managing the models interactions with the DB.
 *
 * @package Framework
 */
class DB
{
    public $dbConnection;

    public function __construct()
    {
        $this->dbConnection = pg_connect("
        host=*
        user=*
        password=*
        ");
    }

    public function connect()
    {
        return $this->dbConnection;
    }
}