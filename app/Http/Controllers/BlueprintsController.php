<?php

namespace App\Http\Controllers;

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

    //
}
