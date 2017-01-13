<?php

namespace App\Http\Controllers;

use App\Mineral;

class MineralsController extends Controller
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

    public function index($minerals = []){
        return response()->json(Mineral::all());
    }

}