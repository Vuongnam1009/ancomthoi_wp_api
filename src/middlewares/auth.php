<?php
require_once ANCOMTHOI_REST_API_PATH . '/errors/CustomError.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';
class Auth_Middleware
{
    public static function auth($req)
    {
        $codes = new Codes();
        $headers = $req->get_headers();
        $route = $req->get_route();
        $authorization = $headers['authorization'];
        if (!$authorization) {
            new Custom_Error($codes->UNAUTHORIZED);
        };
        list($tokenType, $accessToken) = explode(" ", $authorization[0]);
        if ($tokenType !== "Bearer") {
            new Custom_Error($codes->UNAUTHORIZED);
        };
        $user = Auth_Service::verifyAccessToken($accessToken);
        if (!$user) {
            new Custom_Error($codes->UNAUTHORIZED);
        }
        $req["user"] = $user;
        if (strpos("/logout", $route) || strpos("/verify", $route)) {
            $req->set_param('accessToken', $accessToken);
        }
    }
}
