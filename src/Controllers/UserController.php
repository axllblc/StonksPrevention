<?php

namespace App\Controllers;
use App\Controllers\BaseController;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\JWT;

class UserController extends BaseController
{

    private $key = "supersecretkeyyoushouldnotcommittogithub";

    public static function validate_jwt_token($jwt_token, $secret_key) {
        try {
            return JWT::decode($jwt_token, $secret_key, array('HS256'));
        } catch (ExpiredException $e) {
            throw new \Exception('Token expired');
        } catch (SignatureInvalidException $e) {
            throw new \Exception('Invalid token signature');
        } catch (BeforeValidException $e) {
            throw new \Exception('Token not valid yet');
        } catch (\Exception $e) {
            throw new \Exception('Invalid token');
        }
    }

    public static function generate_jwt_token($user_id, $secret_key) {
        $issued_at = time();
        $expiration_time = $issued_at + (60 * 60); // valid for 1 hour

        $payload = array(
            'iat' => $issued_at,
            'exp' => $expiration_time,
            'sub' => $user_id
        );

        return JWT::encode($payload, $secret_key, 'HS512');
    }

    public function login($request,$response, $args){

        $username = $request->getParsedBody('username');
        $password = $request->getParsedBody('password');

        $user_id = 1; // assuming the user is authenticated
        $secret_key = 'LaMonsterCestPourLesFaiblesMoiJeLeFaisSansRien';
    
        $jwt_token = UserController::generate_jwt_token($user_id, $secret_key);
    
        $response_data = array('jwt' => $jwt_token);
        $response->getBody()->write(json_encode($response_data));
        return $response->withHeader('Content-Type', 'application/json');
    
    }
}
