<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

use App\User;

class Controller extends BaseController
{
    public function getOpenauthCode(Request $request){

    	$code = $request->input('code');
    	$auth = User::GetAuthToken($code);

        if(isset($auth->error)) {
            return view('blueprints');
        }

        $this->setAuthCookie($auth);
		
    	return view('blueprints');

    }

    public function getRefreshAuthCode(){
        if(empty($_COOKIE['Auth'])){
            return (new Response('Refresh token not found in cookies', 400));
        }
        $auth = json_decode($_COOKIE['Auth']);

        if(!isset($auth->refresh_token)){
            return (new Response('Refresh token not found in cookies', 400));
        }

        $auth = User::RefreshAuthToken($auth->refresh_token);
        
        $this->setAuthCookie($auth);

        return view('blueprints');
    }

    private function setAuthCookie($auth){

        Log::info(json_encode($auth));
        $auth->startTime = time();

        User::GetCharacterInfo($auth);
        
        $host = explode(':', $_SERVER['HTTP_HOST']);
        setcookie("Auth", json_encode($auth), strtotime( '+30 days' ), '/', array_shift($host) );

    }

}
