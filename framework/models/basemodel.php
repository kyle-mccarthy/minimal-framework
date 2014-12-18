<?php namespace Framework\Models;

use Framework\DB;

class BaseModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new DB();
        $this->db = $this->db->connect();
    }
}