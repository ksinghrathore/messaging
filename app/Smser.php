<?php
/**
 * Created by PhpStorm.
 * User: rathore
 * Date: 18/7/18
 * Time: 5:16 PM
 */

namespace App;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Smser
{
    public static function send($mobile, $message, $udh)
    {
        $new_log = new Logger('Log-SMS');
        $new_log->pushHandler(new StreamHandler(storage_path('logs/sms.log')));
        $new_log->addInfo("Mobile: " . $mobile . "\n UDH: " . $udh . "\n Message: " . $message);
    }
}