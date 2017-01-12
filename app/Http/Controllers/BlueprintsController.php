<?php

namespace App\Http\Controllers;

use DB;

class BlueprintsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($blueprints = []){

        if(empty($blueprints)) return response()->json($blueprints);
        if(!is_array($blueprints))  $blueprints = json_decode( $blueprints, true );

        $blueprints = DB::select('SELECT 
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
            pb.typeid in('.implode(',',$blueprints).')');

        return response()->json($blueprints);
    }

    //
}
