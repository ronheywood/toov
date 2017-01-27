<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

use App\User;

class Controller extends BaseController
{
    public function getOpenauthCode(Request $request){

    	$code = $request->input('code');
    	$auth = User::GetAuthToken($code);

        if(isset($auth->error)) {
            return redirect('/');
        }

        $this->setAuthCookie($auth);
		
    	return redirect('/');

    }

    public function getRefreshAuthCode(){

        if(empty($_COOKIE['Auth'])){
            return redirect('/');
        }
        $auth = json_decode($_COOKIE['Auth']);

        if(!isset($auth->refresh_token)){
            return $this->getLogout();
        }

        $auth = User::RefreshAuthToken($auth->refresh_token);
        
        $this->setAuthCookie($auth);

        return view('blueprints');
    }

    public function getLogout(){
        $host = explode(':', $_SERVER['HTTP_HOST']);
        setcookie('Auth', null, -1, '/', array_shift($host));
        return redirect('/');
    }

    private function setAuthCookie($auth){

        Log::info(json_encode($auth));
        $auth->startTime = time();

        User::GetCharacterInfo($auth);
        
        $host = explode(':', $_SERVER['HTTP_HOST']);
        setcookie("Auth", json_encode($auth), strtotime( '+30 days' ), '/', array_shift($host) );

    }

}
