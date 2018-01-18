<?php

use ATehnix\VkClient\Client;
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
	 ->middleware(\App\Http\Middleware\VKAuthorize::class)
     ->group(function () {

     Route::prefix('users')->group(function () {

	     Route::post('getById', 'VKController@getUsersById');

     });

     // Only for standalone
     Route::prefix('messages')->group(function () {

	     Route::post('get', 'VKController@getMessages');
	     Route::post('text', 'VKController@sendMessage');
	     Route::post('history', 'VKController@getHistoryMessages');
	     Route::post('dialogs', 'VKController@getDialogs');

     });

     Route::prefix('groups')->group(function () {

	     Route::post('getOneById', 'VKController@getGroupById');
	     Route::post('/', 'VKController@getGroups');

     });

     Route::prefix('friends')->group(function () {

	     Route::post('/', 'VKController@getFriends');

     });


     Route::prefix('likes')->group(function () {

	     Route::post('/', 'VKController@getFriends');

     });

});


