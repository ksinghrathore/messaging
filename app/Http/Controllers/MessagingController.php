<?php
/**
 * Created by PhpStorm.
 * User: rathore
 * Date: 16/7/18
 * Time: 5:17 PM
 */

namespace App\Http\Controllers;


use App\Jobs\SmsJob;
use App\Smser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessagingController extends Controller
{

    public function getHexWithPadding($num, $padding = 2)
    {
        return str_pad(dechex($num), 2, 0, STR_PAD_LEFT);
    }

    public function requestSMS(Request $request)
    {
        if (!$request->has('mobile')) {
            return response(["error" => "Please provide mobile number to send sms."], 400);
        }

        if (!$request->has('message') || empty($request->get('message'))) {
            return response(["error" => "Kindly provide message to send sms"], 400);
        }

        $mobile = $request->get('mobile');
        $maxMultiPartSmsSize = 153;
        $messages = str_split($request->get('message'), $maxMultiPartSmsSize);
        $noOfMessages = count($messages);

        if (!preg_match('/^[0-9]{10,12}$/', $mobile)) {
            return response(["error" => "Provided mobile number format is incorrect. (Ex 8877665544 or 918877665544 or 08877665544)"], 400);
        }

        foreach ($messages as $key => $message) {
            $identity = rand(0, 255);
            $udh = "050003" . $this->getHexWithPadding($identity) . "05" . $this->getHexWithPadding($noOfMessages) . $this->getHexWithPadding($key + 1);
            $this->dispatch((new SmsJob($mobile, $message, $udh))->delay(Carbon::now()->addSeconds($key + 1)));
        }
        return response("SMS successfully processed");
    }
}