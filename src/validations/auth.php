<?php
require_once ANCOMTHOI_REST_API_PATH . '/errors/CustomError.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';
class Auth_Validation
{
    public static function register($req)
    {
        $code = new Codes();
        $email = $req['email'];
        if (!preg_match(
            "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
            $email
        )) {
            new Custom_Error($code->INVALID_REQUEST);
        }
        return true;
    }
    public static function login($req)
    {
        $code = new Codes();
        $email = $req['email'];
        if (!preg_match(
            "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
            $email
        )) {
            new Custom_Error($code->INVALID_REQUEST);
        }
        return true;
    }
}
