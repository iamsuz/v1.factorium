<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Color;
use Auth;
use Illuminate\Http\Request;
use App\Mailers\AppMailer;
use App\User;
use App\UserRegistration;
use Illuminate\Support\Facades\DB;
Use Carbon\Carbon;

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
    protected $user;

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
    public function sendEmail(Request $request,AppMailer $mailer)
    {
        $this->validate($request, ['email' => 'required|email']);
        $token = str_random(60);
        $user_info = $request->email;
        $user = User::where('email', request()->input('email'))->first();
        if(isset($user)){
            $user1 = DB::Table('password_resets')->where('email',$user_info)->first();
            if(isset($user1)){
                DB::table('password_resets')->where('email','=',$user_info)->update([
                    'token'=> $token,
                    'created_at'=> Carbon::now()
                ]);
            }else{
                DB::table('password_resets')->insert(array('email' => $user_info,'token' => $token, 'created_at'=> Carbon::now()));
            }
            $mailer->sendPasswordResetEmailToUser($user_info,$token);
            return redirect()->back()->withMessage('<p class="alert alert-success text-center">We have e-mailed your password reset link!</p>');
        }else{
            $user2 = UserRegistration::where('email', request()->input('email'))->first();
            if(isset($user2)){
                return redirect()->back()->withMessage('<p class="alert alert-info text-center">Please check your account! We already sent you mail for activation.</p>');
            }else{
                return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Please Register!! Email Does not exist.</p>');
            }
        }
    }
}
