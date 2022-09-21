<?php
require_once ANCOMTHOI_REST_API_PATH . '/services/user.php';
class User_Controller
{
    public static function getAllUsers($req)
    {
        $users = User_Service::getAllUsers();
        return array(
            "status" => "1",
            "result" => $users,
        );
    }
    public static function updateUser($req)
    {
        $data = $req->get_body_params();
        $user = $req['user'];
        $userInfo = User_Service::updateUser($user->id, $data);
        return array(
            "status" => "1",
            "result" => $userInfo,
        );
    }
    public static function changePassword($req)
    {
        $data = $req->get_body_params();
        $user = $req['user'];
        User_Service::updatePassword($user->id, $data);
        return array(
            "status" => "1",
        );
    }
}
