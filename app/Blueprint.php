<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Blueprint extends Model
{
	
	public static function GetBlueprintInventables(Array $blueprintTypeIdList){

		return DB::select('SELECT 
            input.typeId as blueprintCopyId,
            input.typeName as Input,
            output.typeName as Invents,
            output.typeId as inventedBlueprintId,
            productBlueprintBuilds.typeId as outputs,
            productBlueprintBuildItem.typeName as Produces,
            pb.probability as baseProbability
        FROM 
            industryactivityprobabilities pb
        JOIN invtypes input on pb.typeId = input.typeId
        JOIN invtypes output on pb.productTypeId = output.typeId
        JOIN eve.industryactivityproducts productBlueprintBuilds on output.typeId = productBlueprintBuilds.typeId
        JOIN invtypes productBlueprintBuildItem on productBlueprintBuilds.productTypeId = productBlueprintBuildItem.typeId
        WHERE 
            pb.typeid in('.implode(',',$blueprintTypeIdList).')');

	}

	public static function IndustryActivityMaterials(Array $typeIds, $activityId = 1) 
	{
		return DB::select('SELECT 
				im.typeID,
				im.materialTypeID,
			    m.typeName,
			    im.quantity,
			    m.description,
			    m.volume,
			    m.basePrice,
			    m.marketGroupID,
			    m.iconID,
			    g.groupName
			FROM industryactivitymaterials im
			JOIN invtypes m on im.materialTypeId = m.typeId
			JOIN invgroups g on m.groupId = g.groupId
			where im.typeId in('.implode(',' , $typeIds ).' )
			and im.activityId = 1
			order by im.typeId');
	}
}