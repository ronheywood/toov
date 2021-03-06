<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\ESI;

class Blueprint extends Model
{
	
	private static $baseSQL = 'SELECT 
			bp.typeId as blueprintCopyId,
		    bp.typeName as typeName,
		    originBlueprintBuilds.productTypeId as blueprintCreatesId,
		    originBlueprintBuilds.quantity as blueprintCreatesQuantity,
		    output.typeName as Product,
		    output.typeId as productBlueprintId,
		    productBlueprintBuilds.productTypeId as tech2ItemId,
		    productBlueprintBuildItem.typeName as tech2ItemName,
		    pb.probability as baseProbability,
		    0 as runs,
		    1 as quantity,
		    0 as materialEfficiency,
		    0 as timeEfficiency
		FROM 
		invtypes bp
		JOIN eve.industryactivityproducts originBlueprintBuilds ON bp.typeId = originBlueprintBuilds.typeId and originBlueprintBuilds.activityId = 1
		LEFT OUTER JOIN industryactivityprobabilities pb on bp.typeid = pb.typeid
		LEFT OUTER JOIN invtypes input ON pb.typeId = input.typeId
		LEFT OUTER JOIN invtypes output ON pb.productTypeId = output.typeId
		LEFT OUTER JOIN eve.industryactivityproducts productBlueprintBuilds ON output.typeId = productBlueprintBuilds.typeId
		LEFT OUTER JOIN invtypes productBlueprintBuildItem ON productBlueprintBuilds.productTypeId = productBlueprintBuildItem.typeId
        WHERE 
        bp.typeName like \'%Blueprint\'';

	public static function GetBlueprintInventables(Array $blueprintTypeIdList){

		return DB::select( self::$baseSQL . ' AND bp.typeid in('.implode(',',$blueprintTypeIdList).')');

	}

	public static function GetBlueprintsFromAssetList($charId){

		$assetList = json_decode(ESI::get('characters/'.$charId.'/assets/'));
		if(empty($assetList)) return [];
		
		return self::mergeBlueprintsFromAssetList($assetList); 
 
	}

	private static function mergeBlueprintsFromAssetList($assetList){
		
		$blueprintTypes = self::allBlueprints();
		$blueprints = array();
		
		$attributes= '@attributes';

		foreach($assetList as $key=>$asset){
			$allTechMatches = self::matchBlueprintAsset($blueprintTypes,$asset);

			if( count($allTechMatches) ){

				$base = clone $allTechMatches[0];
				if($base->tech2ItemId){
					$base->tech2Invention = $allTechMatches;
				} else {
					$base->tech2Invention = array();
				}
				
				array_push($blueprints, $base);
			}
		}

		return $blueprints;
	}

	private static function matchBlueprintAsset($blueprintTypes,$asset) {

		$allTechMatches = array();

		foreach($blueprintTypes as $key=>$blueprint){
				
			if( $asset->type_id == $blueprint->blueprintCopyId){
				array_push($allTechMatches, $blueprint);
			}
		}

		return $allTechMatches;
	}

	private static function allBlueprints(){

		return DB::select(self::$baseSQL);

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