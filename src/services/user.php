<?php
require_once ANCOMTHOI_REST_API_PATH . '/errors/CustomError.php';
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';

class User_Service
{
    public static function getAllUsers()
    {
        $user = User_Dao::findAllUsers();
        return $user;
    }
    public static function updateUser($userId, $data)
    {
        $codes = new Codes();
        $userExist = User_Dao::findUser($userId);
        if (!$userExist) {
            new Custom_Error($codes->USER_NOT_FOUND);
        }
        $user = User_Dao::updateUser($userId, $data);
        return $user;
    }
    public static function updatePassword($userId, $data)
    {
        $codes = new Codes();
        $currentPassword = $data['currentPassword'];
        $newPassword = $data['newPassword'];
        //verify password
        $user = User_Dao::findUser($userId);
        if (!$user) {
            new Custom_Error($codes->USER_NOT_FOUND);
        }
        if ($user->password) {
            $isCorrectPassword = Auth_Util::comparePassword($currentPassword, $user->password);
            if (!$isCorrectPassword) {
                new Custom_Error($codes->WRONG_PASSWORD);
            }
        }
        $newGeneratePassword = Auth_Util::generatePassword($newPassword);
        $user = User_Dao::updateUser($userId, array('password' => $newGeneratePassword));
        return $user;
        return $user;
    }
}
