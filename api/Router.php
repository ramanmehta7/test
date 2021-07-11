<?php
/**
 * Created by PhpStorm.
 * User: Mayank
 * Date: 27-08-2017
 * Time: 15:53
 */
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/dashboard/DownloadManager.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/database/settings/SettingsManager.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/api/SessionManager.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/api/LifeCycleManager.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/CrawlerBoard/api/GodMode.php";
class Router
{
    //PATHS
    public static $PATH_LOGIN = "login";
    public static $PATH_LOGOUT = "logout";
    public static $PATH_OVERVIEW = "overview";
    public static $PATH_ADD_TO_QUEUE = "addtoqueue";
    public static $PATH_IS_RUNNING = "isrunning";
    public static $PATH_GET_SETTINGS = "getsettings";
    public static $PATH_UPDATE_SETTINGS = "updatesettings";
    public static $PATH_GET_OUTPUT_LOGS = "getoutputlogs";
    public static $PATH_GET_ERROR_LOGS = "geterrorlogs";
    public static $PATH_BEGIN_CRAWL = "begincrawl";
    public static $GET_PARTY_NAME = "getpartyname";
    //KEYS
    public static $KEY_ID = "id";
    public static $KEY_PASS = "pass";
    public static $KEY_AUTH = "auth";
    public static $KEY_CIN = "cin";
    public static $KEY_CMPY_NAME = "cmpy";
    public static $KEY_TMPL_ID = "tid";
    public static $KEY_DEL_SPEED = "del";
    public static $KEY_DATA_JSON = "json";
    public static $KEY_NAME = "name";
    public static $KEY_PHONE = "phone";
    public static $KEY_EMAIL = "email";
    public static $KEY_FEEDBACK = "feedback";
    public static $KEY_REPORT_ID = "reportid";
    public static $KEY_QUERY = "q";
    public static $KEY_WEB_HOOK = "hook";
    public static $SRC_MOBILE = "MOB";
    public static $SRC_WEB = "WEB";
    public function route($path, $src)
    {
        switch ($path) {
            case Router::$PATH_OVERVIEW:
            {
                if (SessionManager::isSessionAlive()) {
                    return json_encode(DownloadManager::getOverview());
                } else {
                    SessionManager::killExistingSession();
                }
                break;
            }
            case Router::$PATH_LOGIN:
            {
                if (isset($_REQUEST[Router::$KEY_ID]) && isset($_REQUEST[Router::$KEY_PASS])) {
                    SessionManager::killExistingSession();
                    return GodMode::authenticate($_REQUEST[Router::$KEY_ID], $_REQUEST[Router::$KEY_PASS]);
                }
                break;
            }
            case Router::$PATH_ADD_TO_QUEUE:
            {
                if (SessionManager::isSessionAlive()) {
                    if (isset($_REQUEST[Router::$KEY_DATA_JSON])) {
                        return json_encode(DownloadManager::insertPortion($_REQUEST[Router::$KEY_DATA_JSON]));
                    }
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$PATH_IS_RUNNING:
            {
                if (SessionManager::isSessionAlive()) {
                    return LifeCycleManager::checkIfScriptIsRunning();
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$PATH_BEGIN_CRAWL:
            {
                if (SessionManager::isSessionAlive()) {
                    return LifeCycleManager::executeScript();
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$GET_PARTY_NAME:
            {
                //return LifeCycleManager::executeScriptPartyName($_REQUEST[Router::$KEY_DATA_JSON]);
                if (isset($_REQUEST[Router::$KEY_DATA_JSON])) {
                    return LifeCycleManager::executeScriptPartyName($_REQUEST[Router::$KEY_DATA_JSON]);
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$PATH_GET_SETTINGS:
            {
                if (SessionManager::isSessionAlive()) {
                    return json_encode(SettingsManager::getSettings());
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$PATH_UPDATE_SETTINGS:
            {
                if (SessionManager::isSessionAlive()) {
                    return json_encode(SettingsManager::updateSettings($_REQUEST[Router::$KEY_DATA_JSON]));
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$PATH_GET_OUTPUT_LOGS:
            {
                if (SessionManager::isSessionAlive()) {
                    $redirectURI = "http://$_SERVER[HTTP_HOST]/CrawlerBoard/SystemLogViewer.php";
                    header(("Location:" . $redirectURI));
                    exit();
                    return;
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$PATH_GET_ERROR_LOGS:
            {
                if (SessionManager::isSessionAlive()) {
                    $redirectURI = "http://$_SERVER[HTTP_HOST]/CrawlerBoard/ErrorLogViewer.php";
                    header(("Location:" . $redirectURI));
                    exit();
                    return;
                } else {
                    http_response_code(403);
                }
                break;
            }
            case Router::$PATH_LOGOUT:
            {
                SessionManager::killExistingSession();
                $redirectURI = "http://$_SERVER[HTTP_HOST]/CrawlerBoard/Dashboard.php";
                header(("Location:" . $redirectURI));
                exit();
                break;
            }
            default:
                http_response_code(400);
                break;
        }
    }
}
if (isset($_REQUEST['path'])) {
    $router = new Router();
    $path = $_REQUEST['path'];
    if (trim($path) === '') {
        $redirectURI = "http://$_SERVER[HTTP_HOST]/CrawlerBoard/Dashboard.php";
        header(("Location:" . $redirectURI));
        exit();
    }
    echo($router->route($path, "WEB"));
} else {
    http_response_code(404);
    header("Location:/");
}