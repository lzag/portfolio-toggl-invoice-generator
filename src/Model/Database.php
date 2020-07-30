<?php
namespace App\Model;

use App\Helper;

class Database
{
    private $dbpass;
    private $dbuser;
    private $dbname;
    private $dbhost;
    private $port = '3306';
    private $dbh;

    public function __construct()
    {
        $this->dbpass = Helper::configValue('database.dbpass');
        $this->dbuser = Helper::configValue('database.dbuser');
        $this->dbhost = Helper::configValue('database.dbhost');
        $this->dbname = Helper::configValue('database.dbname');
    }

    public function connect()
    {
        $this->dbh = new \PDO(
            'mysql:host=' . $this->dbhost  . ';port=' . $this->port . ';dbname=' . $this->dbname,
            $this->dbuser,
            $this->dbpass
        );
    }

    public function getConn()
    {
        return $this->dbh;
    }
}
