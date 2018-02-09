<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Color;
use Auth;
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $redirectTo = '/';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function getEmail()
    {
        $color = Color::where('project_site',url())->first();
        return view('auth.password',compact('color'));
    }
    public function getReset($token = null)
    {
        $color = Color::where('project_site',url())->first();
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.reset',compact('color'))->with('token', $token);
    }
}
