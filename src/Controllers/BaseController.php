<?php
    
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Utils\DB;
use PDO;


class BaseController
{
    protected $db;
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

}