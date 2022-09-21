<?php
require ANCOMTHOI_REST_API_PATH . '/controllers/user.php';
require_once ANCOMTHOI_REST_API_PATH . '/middlewares/auth.php';
class User_Router
{
    public function __construct()
    {
        add_action('rest_api_init', function () {
            register_rest_route(BASE_ROUTERS, '/users', [
                array(
                    'methods' => 'PUT',
                    'callback' => function ($req) {
                        Auth_Middleware::auth($req);
                        return User_Controller::updateUser($req);
                    },
                ),
                array(
                    'methods' => 'GET',
                    'callback' => function ($req) {
                        return User_Controller::getAllUsers($req);
                    },
                )
            ]);
            register_rest_route(BASE_ROUTERS, '/users/changePassword', array(
                'methods' => 'PUT',
                'callback' => function ($req) {
                    Auth_Middleware::auth($req);
                    return User_Controller::changePassword($req);
                }
            ));
        });
    }
}
