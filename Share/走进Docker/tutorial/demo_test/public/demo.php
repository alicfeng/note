<?php
/**
 * Created by AlicFeng at 2019-07-07 09:40
 */
function checkPort($portt, $ip = '127.0.0.1')
{
    $fp = @fsockopen($ip, $portt, $errno, $errstr, 0.1);
    if (!$fp) {
        return false;
    } else {
        fclose($fp);
        return true;
    }
}

if (checkPort('')) {

}


