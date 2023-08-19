<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$request->header('Authorization')){
            return response()->json([
                "message" => 'Tidak memiliki akses.',
            ], 401);
        }

        $request["user"] = DB::table('personal_access_tokens')->where('token', $request->header('Authorization'))->join('users', 'users.id', '=', 'personal_access_tokens.tokenable_id')->get();

        if(count($request["user"]) == 0){
            return response()->json([
                "message" => "doesnt have permission.",
            ], 403);
        }

        // return response()->json([
        //     "message" => $user,
        // ]);
        
        return $next($request);
    }
}
