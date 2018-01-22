<?php

namespace App\Http\Middleware;

use App\Singletons\Instagram;
use Closure;

class InstagramAuthorize
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
    	$login = $request->header('instagram-username');
    	$password = $request->header('instagram-password');
    	try {
    		Instagram::getInstance()->login($login, $password);
		    if (!Instagram::getInstance()->isLoggedIn) {
	            throw new \Exception('Client is not logged...');
		    }
	    } catch (\Exception $e) {
    		// todo - log, notifying etc
		    return response()->json([
			    'message' => 'Bad credentials: ' . $e->getMessage()
		    ], 403);
	    }
        return $next($request);
    }
}
