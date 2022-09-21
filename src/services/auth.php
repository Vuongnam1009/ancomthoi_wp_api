<?php
require_once ANCOMTHOI_REST_API_PATH . '/daos/user.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/CustomError.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';
require_once ANCOMTHOI_REST_API_PATH . '/utils/auth.php';

class Auth_Service
{
    public static function register($email, $userName, $password)
    {
        $code = new Codes();
        $userExist = User_Dao::findUser(array("email" => $email));
        if ($userExist) {
            new Custom_Error($code->EMAIL_EXIST);
        }
        $password = Auth_Util::generatePassword($password);
        $user = User_Dao::createUser($email, $userName, $password);
        return $user;
    }
    public static function login($email, $password)
    {
        $code = new Codes();
        $user = User_Dao::findUser(array("email" => $email));
        if (!$user) {
            new Custom_Error($code->USER_NOT_FOUND);
        }
        $isCorrectPassword = Auth_Util::comparePassword($password, $user->password);
        if (!$isCorrectPassword) {
            new Custom_Error($code->WRONG_PASSWORD);
        }
        $accessToken = Auth_Util::generateAccessToken($user->id);

        return array($user, $accessToken);
    }
    public static function verifyAccessToken($accessToken)
    {
        $code = new Codes();
        $userId = Auth_Util::compereAccessToken($accessToken);
        $user = User_Dao::findUser($userId);
        if (!$user) {
            new Custom_Error($code->UNAUTHORIZED);
        }
        return $user;
    }
}
