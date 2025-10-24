<?php

namespace App\Http\Middleware;

use App\Http\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        // if token exist 
        $token = $request->cookie('token');
        if(!$token){
            return response()->json([
                    'status' =>false,
                    "message"=>"Unauthorized user",
            ]);
        }

        $token_verification = JWTToken::VerifyToken($token);

        if($token_verification === 'unauthorize' ){
            return response()->json([
                    'status' =>false,
                    "message"=>"Unauthorized user",
            ]);
        }else{
            $request->headers->set('email',$token_verification->userEmail);
            $request->headers->set('id',$token_verification->userId);
             return $next($request);
        }
       
    }
}
