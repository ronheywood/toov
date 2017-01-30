<?php
namespace App;

use DB;

class ESI
{
	
	public static function Get($url, $method = 'GET', Array $fields= [], Array $headers = []){
        
        $root = 'https://esi.tech.ccp.is/latest/';

		//ESI api requires bearer token
		//this should have been gated by the implementors Auth middleware but we'll check it out anyway...
        $auth = json_decode($_COOKIE['Auth']);
        if(empty($auth) || empty($auth->access_token)) return false;

        $authorization = "Authorization: Bearer " . $auth->access_token;

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $root.$url);

        if($method == 'POST'){
        	curl_setopt($ch,CURLOPT_POST, 1);
        	curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));
		}

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

        //execute post
        $result = curl_exec($ch);

        
        if($result === false)
        {
            die('Curl error: ' . curl_error($ch) );
        }

        //close connection
        curl_close($ch);

        return $result;
    }

}