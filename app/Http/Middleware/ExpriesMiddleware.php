<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Exceptions\InvalidSignatureException;

class ExpriesMiddleware
{
    /**
     * The names of the parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $ignore = [
        //
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $relative = null)
    {
        if($request->hasValidSignatureWhileIgnoring($this->ignore, $relative !== 'relative')) {
            return $next($request);
        }

        throw new InvalidSignatureException($request->route()->parameter('code'));
    }
}
