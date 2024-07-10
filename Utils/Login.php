<?php

class Utils_Login
{
    static function register_session($user, $email)
    {
        $_SESSION["id"] = $user;
        $_SESSION["username"] = $email;
    }

    static function delete_session()
    {
        unset($_SESSION["username"]);
        unset($_SESSION["id"]);
    }
}