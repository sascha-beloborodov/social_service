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

	     Route::get('getById', 'VKController@getUsersById');

     });

     // Only for standalone
     Route::prefix('messages')->group(function () {

	     Route::get('get', 'VKController@getMessages');
	     Route::post('text', 'VKController@sendMessage');
	     Route::get('history', 'VKController@getHistoryMessages');
	     Route::get('dialogs', 'VKController@getDialogs');

     });

     Route::prefix('groups')->group(function () {

	     Route::get('getOneById', 'VKController@getGroupById');
	     Route::get('/', 'VKController@getGroups');

     });

     Route::prefix('friends')->group(function () {

	     Route::get('/', 'VKController@getFriends');

     });


     Route::prefix('likes')->group(function () {

	     Route::post('/to', 'VKController@toLikeById');

     });


     Route::prefix('posts')->group(function () {

	     Route::get('one', 'VKController@getOnePost');
	     Route::get('/', 'VKController@getPosts');
	     Route::post('create', 'VKController@createPost');
	     Route::put('edit', 'VKController@editPost');
	     Route::delete('delete', 'VKController@deletePost');
	     Route::get('comments', 'VKController@getComments');
	     Route::post('comments/create', 'VKController@createPostComment');
	     Route::put('comments', 'VKController@editPostComment');
	     Route::delete('comments', 'VKController@deletePostComment');
     });

});


