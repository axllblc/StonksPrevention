<?php
require __DIR__ . '/../vendor/autoload.php';
use App\Utils\DB;

use Slim\Psr7\Request as Request;
use Slim\Psr7\Response as Response;

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\JwtAuthenticationMiddleware;

use App\Controllers\{HomeController, UserController};

$db = new DB();
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// $app->add(new BasePathMiddleware($app));

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->add(new Tuupola\Middleware\JwtAuthentication([
  "algorithm" => ["HS512"],
  'secure' => false,
  "path" => ["/customers-data/"],
  "ignore" => ["/auth/login"],
  "attribute" => "jwt",
  "secret" => "LaMonsterCestPourLesFaiblesMoiJeLeFaisSansRien",
  "after" => function ($response, $arguments) {
    return $response->withHeader("X-Musk", "Stonks");
  },
  "error" => function ($response, $arguments) {
    $data["status"] = "error";
    $data["message"] = $arguments["message"];

    $response->getBody()->write(
        json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
    );

    return $response->withHeader("Content-Type", "application/json");}
]));

$app->get('/', [HomeController::class, 'home']);

$app->group('/auth',function(RouteCollectorProxy $group){
    $group->post('/login', [UserController::class, 'login']);
});


$app->post('/customers-data/all', function (Request $request, Response $response) use ($db) {
    $sql = "SELECT * FROM customers";
   
    try {
      $conn = $db->connect();
      $stmt = $conn->query($sql);
      $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
      $db = null;
     
      $response->getBody()->write(json_encode($customers));
      return $response
        ->withHeader('content-type', 'application/json')
        ->withStatus(200);
    } catch (PDOException $e) {
      $error = array(
        "message" => $e->getMessage()
      );
    }

    
      $response->getBody()->write(json_encode($error));
      return $response->withHeader('content-type', 'application/json')->withStatus(500);
});

$app->run();
