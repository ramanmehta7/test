<?php
/**
 * Created by PhpStorm.
 * User: mayank
 * Date: 03/06/19
 * Time: 11:41 AM
 */

class GenUtils
{
    /**
     * Concatenates the elements of the array by the separator.
     * @param $array
     * @param string $separator
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function concatArray($array, $separator = ',', $prefix='', $suffix='')
    {
        $outputString = '';
        for ($i = 0; $i < sizeof($array); $i++) {
            if ($i != 0) {
                $outputString .= ($separator . ' ');
            }
            $outputString .= ($prefix . $array[$i] . $suffix);
        }

        return trim($outputString);
    }

    public static $HASH_LOOP_COUNT = 20;

    public static function generateHash($content)
    {
        $hash = $content;
        for ($i = 0; $i < GenUtils::$HASH_LOOP_COUNT; $i++) {
            $hash = hash('sha256', $hash);
        }
        return $hash;
    }

    /**
     * used only for passwords
     */
    public static final function generatePassHash($content) {
        return GenUtils::generateHash($content);
    }

    public static function genRand($length) {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, $length) as $k) $rand .= $seed[$k];

        return $rand;
    }

    public static function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}