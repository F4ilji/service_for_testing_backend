<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\TestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;

class CheckFinishedSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $actualSession = TestUser::where('user_id', $user->id)->where('end_test', '>', Date::now())->first();
        if($actualSession) {
            $request->merge([
                'test_id' => $request->route('test_id'),
                'session_id' => $actualSession->id,
            ]);
            return $next($request);
        } else {
            return response(['message' => 'seesion not find'], 404);
        }
    }
}
