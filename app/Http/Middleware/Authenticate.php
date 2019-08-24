<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                $url_array = parse_url($request->fullUrl());
                if(isset($url_array['query'])){
                    $newPath = $url_array['path'] .'?'. $url_array['query'];
                } else{
                    $newPath = $url_array['path'];
                }
                $path = ltrim($newPath, '/');
                return redirect()->guest('users/login?next='.$path)->withMessage('<p class="alert alert-warning text-center ">please login</p>');
            }
        }

        // Check if user type is set
        $user = $this->auth->user();
        if (!$user->factorium_user_type) {
            return redirect(route('users.user.type'))->withMessage('<div class="alert alert-warning">Please select user type and proceed!</div>');
        }

        return $next($request);
    }
}
