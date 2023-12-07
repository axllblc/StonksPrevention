<?php
    
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Utils\DB;
use PDO;


class HomeController extends BaseController
{
    public function home(Request $request, Response $response) {
        $sql = "SELECT * FROM customers";
        $conn = $this->db->connect();

        $stmt = $conn->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        $response->getBody()->write(json_encode($customers));
        return $response
            ->withHeader('content-type', 'application/json')
            ->withStatus(200);

    }

}