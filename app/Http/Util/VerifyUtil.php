<?php namespace App\Http\Util;

use App\Http\Model\User;

class VerifyUtil {

    public static function isValidToken($tokenId)
    {
        if ($tokenId && strlen($tokenId) == 26)
        {
            $user = User::select('verified')->where('verify_token',$tokenId)->first();
            return $user['verified'];
        }
        return -1;
    }

}

    