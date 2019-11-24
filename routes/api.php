<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::group(['middleware' => 'auth:api'], function() {
//          show one record       //
    Route::get('/city/{id}', 'onecontroller@show_city');
    Route::get('/province/{id}', 'onecontroller@show_province');
    Route::get('/ziaratname/{id}', 'onecontroller@show_ziaratname');
    Route::get('/imamzade/{id}', 'onecontroller@show_imamzade');
//         index show all record        //
    Route::get('/city', 'onecontroller@index_city');
    Route::get('/province', 'onecontroller@index_province');
    Route::get('/ziaratname', 'onecontroller@index_ziaratname');
    Route::get('/imamzade', 'onecontroller@index_imamzade');
    Route::get('/imamzadetemp', 'ImamzadeTempController@index_imamzadetemp');
//         create  record              //
    Route::post('/imamzade', 'onecontroller@store_imamzade');
    Route::post('/imamzadetemp', 'ImamzadeTempController@store_imamzadetemp');
    Route::post('/ziaratname', 'onecontroller@store_ziaratname');
    Route::post('/search' , 'onecontroller@searchresult');
//          update one record            //
    Route::put('imamzade/{id}', 'onecontroller@update_imamzade');
    Route::put('ziaratname/{id}', 'onecontroller@update_ziaratname');
//           delete record                   //
    Route::delete('imamzade/{id}', 'onecontroller@delete_imamzade');
    Route::delete('ziaratname/{id}', 'onecontroller@delete_ziaratname');
//           register                        //
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\LoginController@loginpost');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::post('prtocity' , 'onecontroller@prtocity');
//});
