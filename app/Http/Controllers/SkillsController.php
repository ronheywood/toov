<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Skill;

class SkillsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //TODO Auth Middleware: (check for bearer token in cookie)
    }

    public function index(){
        return view('skills');
    }

    public function getSkillQueue($characterId){
        return response()->json(Skill::GetSkillQueue($characterId));
    }

    //
}
