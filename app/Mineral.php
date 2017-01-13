<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mineral extends Model 
{

	static private $columns =[
        'typeId', 'groupId', 'typeName','description','mass','volume','basePrice','marketGroupID','iconID'
    ];

    //Database is read only
    protected $fillable = [];

	//SELECT groupId FROM eve.invgroups where groupName = 'Mineral';
	static private $groupId = 18;

	public static function all($columns=Array())
	{
		if(empty($columns)) $columns = self::$columns;

		return DB::select('SELECT ' . implode(',',$columns) .'
			FROM invtypes where groupId = '.self::$groupId.' and published =1');
	}

}