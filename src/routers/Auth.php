<?php
require plugin_dir_path(__FILE__) . '../controllers/auth.php';
require plugin_dir_path(__FILE__) . '../validations/auth.php';
class Auth_Router
{
    public function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route(BASE_ROUTERS, '/register', array(
                'methods' => 'POST',
                'callback' =>  array(new Auth_Controller, 'register'),
                'permission_callback' => array(new Auth_Validation, 'register')
            ));
            register_rest_route(BASE_ROUTERS, '/login', array(
                'methods' => 'POST',
                'callback' => array(new Auth_Controller, 'login'),
                'permission_callback' => array(new Auth_Validation, 'login')
            ));
            register_rest_route(BASE_ROUTERS, '/verify', array(
                'methods' => 'GET',
                'callback' => array(new Auth_Controller, 'verifyAccessToken'),
            ));
        });
    }
}
