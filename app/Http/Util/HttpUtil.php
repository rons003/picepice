<?php namespace App\Http\Util;


class HttpUtil {
        
    public static function getExternalHttpResponse()
    {
        // create curl resource 
        $ch = curl_init();
        // set url 
        curl_setopt($ch, CURLOPT_URL, "http://pice.org.ph/wp-json/tribe/events/v1/events/?page=16");
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        // $output contains the output string
        $output = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch);     

        return response($output)
            ->header('Content-Type', "application/json");        
    }

}