<?php

namespace App\Http\Middleware;

use App\Singletons\Vk;
use Closure;

class VKAuthorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    $token = $request->header('vk-access-token');

	    if (!$token) {
		    return response()->json([
			    'message' => 'You forgot VK ACCESS TOKEN'
		    ], 400);
	    }
	    Vk::getInstance()->setDefaultToken($token);

        return $next($request);
    }
}
