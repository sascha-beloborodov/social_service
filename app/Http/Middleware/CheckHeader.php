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
    	$contentTypeHeader = $request->header('Content-Type');
    	$needed = 'application/json';
    	if ($acceptHeader != $needed || $contentTypeHeader !== $needed) {
		    return response()->json([
		    	'message' => 'Make sure you set Content-Type and Accept in a header'
		    ], 400);
	    }
        return $next($request);
    }
}
