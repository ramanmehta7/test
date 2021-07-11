<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 01/06/19
 * Time: 6:23 PM
 */

class DbValues
{
    //Windows(Devel)
    public static $db_address = "localhost";
    public static $db_username = "root";
    public static $db_pass = "";
    public static $db_name = "litigation";

    //   T A B L E   N A M E S
    public static $TABLE_NAME_DOWNLOAD_MANAGER = "Goa_nic_queue";

    //   F I E L D   N A M E S
    public static $FIELD_NAME_MARK_ID = "mark_id"; //PRIMARY KEY
    public static $FIELD_NAME_DOWNLOAD_STATUS = "status"; //PRIMARY KEY
    public static $FIELD_NAME_ERROR = "error";
    public static $FIELD_NAME_LAST_UPDATE_TIME = "last_update_time";

    public static $CONST_NULL = "NULL";
    public static $CONST_STATUS_PENDING = "PENDING";
    public static $CONST_STATUS_SUCCESS = "SUCCESS";
    public static $CONST_STATUS_FAILED = "FAILED";
}