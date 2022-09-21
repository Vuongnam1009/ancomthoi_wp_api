<?php
require_once ANCOMTHOI_REST_API_PATH . "/models/index.php";
class User_Model
{
    public function Schema()
    {
        $schema = "(
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(150) DEFAULT NULL,
        `userName` varchar(150) DEFAULT NULL,
        `password` varchar(150) DEFAULT NULL,
        `avatar` varchar(200) DEFAULT NULL,
        `dob` DATE NOT NULL,
        `userType` varchar(50) DEFAULT NULL,
        `about` varchar(200) DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `update_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )";
        global $UserModel;
        $UserModel = new Models($schema, "ancomthoi_users");
    }
}
