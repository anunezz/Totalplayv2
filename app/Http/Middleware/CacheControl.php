<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl
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
        $response = $next($request);
        $valid = true;

        foreach ($request->server as $key => $value){
            if ($key == 'REQUEST_URI' ){
                if ($value !== "/"){

                    //dd($value);

                    if (strpos($value,"/api/exportContacts") !==false){
                        $valid = false;
                    }

                    if (strpos($value,"/api/download/excel") !==false){
                        $valid = false;
                    }

                    if (strpos($value,"/api/report") !==false){
                        $valid = false;
                    }

                    if(strpos($value,'responseType=blob')!==false){
                        $valid = false;
                    }
                }

            }
        }

        if ($valid==true){
            $response->header('Cache-Control', "no-cache='Set-Cookie', no-store, must-revalidate");
            $response->header('pragma', 'no-cache');
            $response->header('no-cache', 'Set-Cookie, Set-Directiva Cookie2');
        }

        return $response;
    }
}
