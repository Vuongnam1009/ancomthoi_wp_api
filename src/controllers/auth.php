<?php
require_once ANCOMTHOI_REST_API_PATH . '/services/auth.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/CustomError.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';

class Auth_Controller
{
    function register($req)
    {
        $body = $req->get_body_params();
        $email = $body['email'];
        $userName = $body['userName'];
        $password = $body['password'];
        $user = Auth_Service::register($email, $userName, $password);
        return array(
            "status" => 1,
            "result" => array("user" => $user)
        );
    }
    function login($req)
    {
        $body = $req->get_body_params();
        $email = $body['email'];
        $password = $body['password'];
        list($user, $accessToken) = Auth_Service::login($email, $password);
        return array(
            "status" => 1,
            "result" => array("accessToken" => $accessToken, "user" => $user)
        );
    }
    function verifyAccessToken($req)
    {
        $codes = new Codes();
        $headers = $req->get_headers();
        $authorization = $headers['authorization'];
        if (!$authorization) {
            new Custom_Error($codes->UNAUTHORIZED);
        };
        list($tokenType, $accessToken) = explode(" ", $authorization[0]);
        if ($tokenType !== "Bearer") {
            new Custom_Error($codes->UNAUTHORIZED);
        };
        $user = Auth_Service::verifyAccessToken($accessToken);
        return array(
            "status" => 1,
            "result" => array("user" => $user)
        );;
    }
}
