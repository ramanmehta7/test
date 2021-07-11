<?php

/**
 * Created by PhpStorm.
 * User: Mayank
 * Date: 02-09-2017
 * Time: 11:23
 */
session_start();
class SessionManager
{
    private static $AUTH_TOKEN = "auth_token";
    private static $IS_LOGGED_IN = "is_logged_in";
    private static $SRC = "src";
    private static $IS_LOGGED_IN_POSITIVE = true;
    private static $IS_LOGGED_IN_NEGATIVE = false;

    public static function isSessionAlive() {
        if(isset($_SESSION[SessionManager::$AUTH_TOKEN]) && isset($_SESSION[SessionManager::$IS_LOGGED_IN]) && isset($_SESSION[SessionManager::$SRC])
            && $_SESSION[SessionManager::$IS_LOGGED_IN] === SessionManager::$IS_LOGGED_IN_POSITIVE) {
            return true;
        } else {
            return false;
        }
    }

    public static function beginSession($src, $auth_token) {
        $_SESSION[SessionManager::$SRC] = $src;
        $_SESSION[SessionManager::$AUTH_TOKEN] = $auth_token;
        $_SESSION[SessionManager::$IS_LOGGED_IN] = SessionManager::$IS_LOGGED_IN_POSITIVE;
    }

    public static function killExistingSession() {
        $_SESSION[SessionManager::$SRC] = null;
        $_SESSION[SessionManager::$AUTH_TOKEN] = null;
        $_SESSION[SessionManager::$IS_LOGGED_IN] = SessionManager::$IS_LOGGED_IN_NEGATIVE;
    }

    public static function getAuthorizationToken() {
        return $_SESSION[SessionManager::$AUTH_TOKEN];
    }
}