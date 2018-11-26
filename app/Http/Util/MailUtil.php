<?php namespace App\Http\Util;

use Mail;

class MailUtil {

    public static function send($view, $subject, $data, $opt = array())
    {
        $sendMail = Mail::send($view, ['data' => $data], function ($message) use ($data, $subject) {
            $message->from('administration@pice.org.ph', 'PICE Membership Team')->subject($subject);
            $bccemail = ['xian.calabia@gmail.com'];
            $message->to($bccemail)->bcc($bccemail)->subject($subject);            
        });

        return $sendMail;
    }

}