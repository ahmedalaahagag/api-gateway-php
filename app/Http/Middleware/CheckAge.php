<?php

namespace App\Http\Middleware;
use Closure;
class CheckAge
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
        if ($request->input('age') >= 80) {
            return 'You do not satisfy middleware security check and hence cannot proceed';
        }
        return $next($request);
    }
}
