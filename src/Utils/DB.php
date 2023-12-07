<?php

namespace App\Utils;

use PDO;

class DB
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'DEV';

    public function connect()
    {
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname;port=3306";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}
