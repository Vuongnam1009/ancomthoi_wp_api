<?php
require_once ANCOMTHOI_REST_API_PATH . '/errors/message.php';
class Custom_Error
{
    private $code;
    public function __construct($code, $param = null)
    {
        $messages = new Messages();
        if ($param) {
            $error = '{
                "status": 0,
                "code":' . $code . ',
                "message":' . $param . '
            }';
            die($error);
        }
        $message = $messages->getErrorMessage($code);
        $error = '{
            "status": 0,
            "code":' . $code . ',
            "message":' . $message . '
        }';
        die($error);
    }
}
