<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Support\Facades\Log;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /*
        POST https://login.eveonline.com/oauth/token HTTP/1.1

        Authorization: Basic bG9...ZXQ=
        Content-Type: application/x-www-form-urlencoded
        Host: login.eveonline.com

        grant_type=authorization_code&code=gEyuYF_rf...ofM0

        Authorization HTTP header: Basic access authentication is used, with the client ID as the username and secret key as the password. The header should be the string “Basic ” plus the Base64 encoded string {client_id}:{client_secret}.

        It is very important to make sure there is no whitespace around or in the string that is being Base64 encoded. If in doubt, try to Base64 encode the sample values provided below and compare them to the results:

        Example client ID: 3rdparty_clientid
        Example secret key: jkfopwkmif90e0womkepowe9irkjo3p9mkfwe
        Concatenated to become: 3rdparty_clientid:jkfopwkmif90e0womkepowe9irkjo3p9mkfwe

        Base64 encoded to: M3JkcGFydHlfY2xpZW50aWQ6amtmb3B3a21pZjkwZTB3b21rZXBvd2U5aXJram8zcDlta2Z3ZQ==

        Resulting in the Authorization header: Basic M3JkcGFydHlfY2xpZW50aWQ6amtmb3B3a21pZjkwZTB3b21rZXBvd2U5aXJram8zcDlta2Z3ZQ==

        grant_type: Must be set to “authorization_code”.

        code: The authorization code obtained earlier.

    */
    public static function GetAuthToken( $authCode ){

            Log::info('Get auth token from code '.$authCode);
            
            $result = self::post(
                'https://login.eveonline.com/oauth/token', 
                array('grant_type'=>'authorization_code','code'=>$authCode)
            );
            
            Log::info($result);
            
            $auth =json_decode($result); 
            return $auth;
    }

    /*POST https://login.eveonline.com/oauth/token HTTP/1.1

    Authorization: Basic bG9...ZXQ=
    Content-Type: application/x-www-form-urlencoded
    Host: login.eveonline.com

    grant_type=refresh_token&refresh_token=gEy...fM0*/
    public static function RefreshAuthToken( $refreshToken ){

            Log::info('Get auth from refresh token  '.$refreshToken);
            
            $result = self::post(
                'https://login.eveonline.com/oauth/token', 
                array('grant_type'=>'refresh_token','refresh_token'=>$refreshToken)
            );
            
            Log::info($result);
            
            $auth =json_decode($result); 
            return $auth;

    }

    public static function GetCharacterInfo( $auth ){

            $auth->charatcerId = 96956057;

    }

    private static function post($url, Array $fields= [], Array $headers = []){
        
        $basic = 'client_id:client_secret';

        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $basic);

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
