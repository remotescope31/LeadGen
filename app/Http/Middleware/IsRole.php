<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsRole
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


        if(Auth::user()){
            if((Auth::user()->role)==2){
                return $next($request);
               // return redirect('admin');
            }
            if((Auth::user()->role)==3){
                return $next($request);
                // return redirect('admin');
            }
            if((Auth::user()->role)==1){
                return $next($request);
                //return redirect('manager');

            }
            if((Auth::user()->role)==0){
                return redirect('users');

               // return $next($request);
            }
        }
        return redirect('login');

    }
}
