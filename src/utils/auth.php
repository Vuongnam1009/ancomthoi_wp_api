<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once ANCOMTHOI_REST_API_PATH . '/errors/CustomError.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';

class Auth_Util
{
    public static function generatePassword($password)
    {
        $options = [
            'cost' => 12,
        ];
        $password = password_hash($password, PASSWORD_BCRYPT, $options);
        return $password;
    }
    public static function comparePassword($passwordCompare, $password)
    {
        return password_verify($passwordCompare, $password);
    }
    public static function  generateAccessToken($userId)
    {
        $expire_claim = $_ENV['JWT_EXPIRES_TIME'] ? (int)$_ENV['JWT_EXPIRES_TIME'] + time() : 70 * 86400 + time(); // expire time in seconds
        $token = array(
            "exp" => $expire_claim,
            "userId" => $userId,
        );
        try {
            $accessToken = JWT::encode($token, $_ENV['JWT_SECRET_KEY'], 'HS256');
            return $accessToken;
        } catch (UnexpectedValueException $e) {
            $code = new Codes();
            new Custom_Error($code->UNAUTHORIZED, $e->getMessage());
        }
    }
    public static function compereAccessToken($accessToken)
    {
        try {
            $token = JWT::decode($accessToken, new Key($_ENV['JWT_SECRET_KEY'], 'HS256'));
            return $token->userId;
        } catch (UnexpectedValueException $e) {
            $code = new Codes();
            new Custom_Error($code->UNAUTHORIZED, $e->getMessage());
        }
    }
}
