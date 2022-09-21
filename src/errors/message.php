<?php
require_once ANCOMTHOI_REST_API_PATH . '/errors/code.php';

class Messages
{
    public function getErrorMessage($code)
    {
        $codes = new Codes();
        switch ($code) {
            case $codes->NOT_FOUND:
                return "Not found";
            case $codes->UNAUTHORIZED:
                return "Unauthorized";
            case $codes->USER_NOT_FOUND:
                return "User is not found";
            case $codes->WRONG_PASSWORD:
                return "Wrong password";
            case $codes->EMAIL_EXIST:
                return "Email existed";
            case $codes->ITEM_EXIST:
                return "Item is exist";
            case $codes->POST_NOT_EXIST:
                return "Post does not exist";
            case $codes->INVALID_REQUEST:
                return "Invalid request";
            default:
                return null;
        }
    }
}
