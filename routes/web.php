<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use ATehnix\VkClient\Auth;
use ATehnix\VkClient\Client;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('vk_auth', function(Request $request) {
	$api = new Client;
	$auth = new Auth('6334864', 'fCFmxcgsobZ1Ht1ftnJB', 'http://127.0.0.1:8000/vk_auth');
	echo "<a href='{$auth->getUrl()}'>ClickMe<a>";
	$token = '-';
	if ($request->get('code')) {
		$token = $auth->getToken($request->get('code'));
	}
//	$api->setDefaultToken($token);
	echo $token;
});