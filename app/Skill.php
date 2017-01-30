<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Skill extends Model
{
	
	private static $baseSQL = 'select * from invTypes where published = true';

	public static function GetSkillQueue($charId){

		$queue = json_decode(self::ESI('characters/'.$charId.'/skillqueue/'));
		if(isset($queue->error)){
			die($queue->error);
		}
		return self::mergeSkillNameWithSkillQueue($queue);
	}

	private static function mergeSkillNameWithSkillQueue($queue){
		
		$embelishedQueue = [];
		foreach($queue as $key=>$trainingSkill){
			$embelishedQueue[$trainingSkill->skill_id] = $trainingSkill;
		}
		$trainingSkills = array_keys($embelishedQueue);

		$referencedSkills = DB::select( self::$baseSQL.' AND typeID in ('.implode(',',$trainingSkills).')' );
		
		foreach($referencedSkills as $key=>$skillDetail){
			$embelishedQueue[$skillDetail->typeID]->skillDetail = $skillDetail;
		}

		return array_values($embelishedQueue);
	}

	//TODO implement ESI interface
	private static function Esi($url, $method = 'GET', Array $fields= [], Array $headers = []){
        
        $root = 'https://esi.tech.ccp.is/latest/';

		//ESI api requires bearer token
		//this should be gated by the Auth middleware but we'll check it out anyway...
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