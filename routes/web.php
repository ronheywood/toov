<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return view('blueprints');
});

$app->get('/blueprints', 'BlueprintsController@blueprintsFromAssetList');
$app->get('/blueprints/{blueprints}', 'BlueprintsController@index');
$app->get('/blueprints/{blueprints}/materials', 'BlueprintsController@blueprintMaterials');


$app->get('/minerals', 'MineralsController@index');