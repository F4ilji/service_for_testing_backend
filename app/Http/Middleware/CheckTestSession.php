<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Carbon\Carbon;
use App\Models\Test;
use App\Models\TestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\Response;

class CheckTestSession
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
            throw new Exception('Есть актуальная сессия');
        } else {
            $request->merge(['test_id' => $request->route('test_id')]);
            return $next($request);
        }
    }
}
