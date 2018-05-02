<?php

namespace App\Http\Middleware;

use Closure;

class apiLocale
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
        $langCode   = $request->segment(2);
        $available  = ['ar','en'];
        if(!in_array($langCode,$available)){
            return response()->json(['scode'=>400,'message'=>'Some Errors Happened','errors'=>["Wrong Lang Code"],'data'=>[]]);
        }
        app()->setLocale($langCode);
        return $next($request);
    }
}
