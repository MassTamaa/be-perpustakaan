<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $userOwner = User::where('name', 'owner')->first();

        if($user && $user->id === $userOwner->id){
            return $next($request);
        }

        return response()->json([
            "message" => "You Cannot Access the Owner Page",
        ], 401); 
    }
}
