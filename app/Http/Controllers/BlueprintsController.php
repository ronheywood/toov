<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Blueprint;
use App\Mineral;

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

        return response()->json(Blueprint::GetBlueprintInventables($blueprints));
    }

    public function blueprintMaterials($blueprints = []){

        if(empty($blueprints)) return response()->json($blueprints);
        if(!is_array($blueprints))  $blueprints = json_decode( $blueprints, true );
        
        return response()->json( Blueprint::IndustryActivityMaterials($blueprints) );

    }

    public function blueprintsFromAssetList(Request $request){

        $characterId = $request->input('characterId');
        $keyID = $request->input('keyID');
        $apiVCode = $request->input('vCode');
        
        if(empty($characterId) || empty($keyID) || empty($apiVCode) ) return response()->json([]);

        
        return response()->json( 
            Blueprint::GetBlueprintsFromAssetList($characterId, $keyID, $apiVCode) 
            );
    }

    //
}
