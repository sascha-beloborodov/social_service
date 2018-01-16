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

Route::prefix('instagram')
	->middleware(\App\Http\Middleware\CheckHeader::class)
	->middleware(\App\Http\Middleware\InstagramAuthorize::class)
	->group(function () {

	Route::prefix('messages')->group(function () {

		Route::post('text', 'InstagramController@sendMessage');
		Route::post('image', 'InstagramController@sendImage');

	});
});

Route::prefix('vk')
     ->middleware(\App\Http\Middleware\CheckHeader::class)
     ->group(function () {

     Route::prefix('messages')->group(function () {

	     Route::post('send', 'InstagramController@sendMessage');

     });
});


