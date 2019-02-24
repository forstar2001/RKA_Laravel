<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\JWT;
use Illuminate\Support\Facades\Input;

class authJWT
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
        $response = [
            'success' => 0,
            'msg' => ''
        ];
        // $token = Input::get('token');     
        $token = $request->header('token');

        if($token != ""){   
            $token = urldecode($token);
            $jwt = new JWT();
            $secret = $jwt->getSecretKey();
            try{
                $decoded = JWT::decode($token, $secret);
                $request->userInfo = $decoded;
            }catch(\Exception $e){
                $response['msg'] = "Invalid token.";
            
                return response()->json($response);
            }
        }else{
            $response['msg'] = "Unauthorized access.";
            
            return response()->json($response);
        }
        return $next($request);
    }
}
