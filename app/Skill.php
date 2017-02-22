<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\ESI;

class Skill extends Model
{
	
	private static $baseSQL = 'select * from invtypes where published = true';

	public static function GetSkillQueue($charId){

		$queue = json_decode(ESI::Get('characters/'.$charId.'/skillqueue/'));
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

}