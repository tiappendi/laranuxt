<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\RegisterController;
// use App\Http\Controllers\Auth\RegistersUsers;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// route group for uer authenticated only
Route::group(['middleware' => ['auth:api']], function () {

});


// route group for guests only
Route::group(['middleware' => ['guest:api']], function () {
    // registration routes
    Route::post('register', 'Auth\RegisterController@register');
});
// Route::post('/register', 'Auth\RegisterController@register');

// Route::group([

//     'middleware' => ['auth:api'],
//     'prefix' => 'auth'

// ], function ($router) {
//     Route::post('register', 'Auth\RegisterController@register');
//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');
// });



Route::get('/', function () {
    return response()->json(['message' => 'HEllo wordldl'], 200);
});
