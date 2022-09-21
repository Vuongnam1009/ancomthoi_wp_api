<?php

class User_Dao
{
    public static function findAllUsers()
    {
        global $UserModel;
        $user = $UserModel->find();

        return $user;
    }
    public static function findUser($condition)
    {
        global $UserModel;
        if (is_array($condition) && $condition !== null) {
            $user = $UserModel->findOne($condition);
            return $user;
        } else {
            $user = $UserModel->findById($condition);
            return $user;
        }
        return null;
    }
    public static function createUser($email, $userName, $password)
    {
        global $UserModel;
        $arr = array("email" => $email, "userName" => $userName, 'password' => $password);
        $user = $UserModel->create($arr);
        return $user;
    }
    public static function updateUser($userId, $data)
    {
        global $UserModel;
        $user = $UserModel->findByIdAndUpdate($userId, $data);
        return $user;
    }
}
