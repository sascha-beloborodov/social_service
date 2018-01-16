<?php

namespace App\Http\Middleware;

use Closure;

class CheckHeader
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
    	$acceptHeader = $request->header('Accept');
    	$needed = 'application/json';
    	if ($acceptHeader != $needed) {
		    return response()->json([
		    	'message' => 'Make sure you set and Accept in a header'
		    ], 400);
	    }
        return $next($request);
    }
}
