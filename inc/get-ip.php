<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 21.03.13
 * Time: 16:14
 * To change this template use File | Settings | File Templates.
 */


function getip()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            {
                $ip = getenv("HTTP_CLIENT_IP");
            }
        elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            }
        elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            {
                $ip = getenv("REMOTE_ADDR");
            }
        elseif (!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        else
            {
                $ip = "unknown";
            }

        return ($ip);
    }