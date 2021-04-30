<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthenticateSecretario
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }
        $us = Usuario::where('token', $request->bearerToken())->first();
        if($us != null){
            foreach( $us->roles as $rol ){
                if($rol->nombre == 'Secretario'){
                    return $next($request);
                }
            }
            return response('Usuario no es Secretario.', 401);
        }
        return response('Unauthorized.', 401);

    }
}
