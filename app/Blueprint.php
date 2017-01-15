<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Blueprint extends Model
{
	
	public static function GetBlueprintInventables(Array $blueprintTypeIdList){

		return DB::select('SELECT 
			bp.typeId as blueprintCopyId,
		    bp.typeName as Input,
		    originBlueprintBuilds.productTypeId as blueprintCreatesId,
		    originBlueprintBuilds.quantity as blueprintCreatesQuantity,
		    output.typeName as Product,
		    output.typeId as productBlueprintId,
		    productBlueprintBuilds.productTypeId as tech2ItemId,
		    productBlueprintBuildItem.typeName as tech2ItemName,
		    pb.probability as baseProbability
		FROM 
		invtypes bp
		JOIN eve.industryactivityproducts originBlueprintBuilds ON bp.typeId = originBlueprintBuilds.typeId and originBlueprintBuilds.activityId = 1
		LEFT OUTER JOIN industryactivityprobabilities pb on bp.typeid = pb.typeid
		LEFT OUTER JOIN invtypes input ON pb.typeId = input.typeId
		LEFT OUTER JOIN invtypes output ON pb.productTypeId = output.typeId
		LEFT OUTER JOIN eve.industryactivityproducts productBlueprintBuilds ON output.typeId = productBlueprintBuilds.typeId
		LEFT OUTER JOIN invtypes productBlueprintBuildItem ON productBlueprintBuilds.productTypeId = productBlueprintBuildItem.typeId
        WHERE bp.typeid in('.implode(',',$blueprintTypeIdList).')');

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