<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Superadmin
{
    protected $auth;

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
        $user = $this->auth->user();
        if(!$this->auth->guest()) {
            if (!$user->roles->contains('role', 'superadmin')) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->route('users.show', [$user])->withMessage('<p class="alert alert-warning text-center ">Super Admin Only</p>');
                }
            }
            else{
                if($user->registration_site != url()){
                    return redirect()->route('users.show', [$user])->withMessage('<p class="alert alert-warning text-center ">You are not Super Admin for this site</p>');
                }
            }
        }
        return $next($request);
    }
}
