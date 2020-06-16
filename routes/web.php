<?php

use \Illuminate\Http\Request;

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

$router->get('/', function () use ($router) {
    return view('main');
});


$router->get('/login', 'AuthController@login');
$router->get('/callback', 'AuthController@callback');
$router->get('/refresh', 'AuthController@refresh');
