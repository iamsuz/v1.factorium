<?php

namespace App\Http\Controllers;

use Session;
use App\User;
use App\Color;
use Carbon\Carbon;
use App\UserRegistration;
use App\Project;
use App\ProjectEOI;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserAuthRequest;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;


class UserAuthController extends Controller
{
    /**
     * constructor for UsersController
     */
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['login','authenticate','authenticateCheck']]);
    }

    /**
     * redirection path after signup
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (Auth::user()->roles->contains('role', 'admin') || Auth::user()->roles->contains('role', 'master')) {
            return 'dashboard.index';
        }
        return 'users.index';
    }

    /**
     * renders login page
     * @return view login page
     */
    public function login(Request $request)
    {
        if($request->next)
        {
            $request->source ? $request->attributes->add(['next'=>$request->next."&source=".$request->source]) : $request->next;
        }
        $color = Color::where('project_site',url())->first();
        $redirectNotification = $request->has('redirectNotification')?$request->redirectNotification:0;
        return view('users.login',compact('color', 'redirectNotification'));
    }

    /**
     * logout user
     * @return view login
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('users.login')->withMessage('<p class="alert alert-success text-center"> Successfully Logged out!</p>');
    }


    public function authenticateCheck(Request $request)
    {
        $user = User::where('email',$request->email)->first();
        if($user){
            return $request->email;
        }else{
            return 'fail';
        }
    }
    public function successEoi(Request $request)
    {
        if(Auth::check())
        {
            $color = Color::where('project_site',url())->first();
            return view('users.successEoi',compact('color'));
        }
        return redirect()->route('users.login')->withMessage('<p class="alert alert-danger text-center">Please Login</p>');
    }
    public function authenticateEoi(UserAuthRequest $request,AppMailer $mailer)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active'=>1], $request->remember)) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            Session::flash('loginaction', 'success.');
            $color = Color::where('project_site',url())->first();
            $project = Project::findOrFail($request->project_id);
            $user = Auth::user();
            $user_info = Auth::user();
            $min_amount_invest = $project->investment->minimum_accepted_amount;
            if((int)$request->investment_amount < (int)$min_amount_invest)
            {
                return redirect()->back()->withErrors(['The amount to invest must be at least $'.$min_amount_invest]);
            }
            if((int)$request->investment_amount % 1000 != 0)
            {
                return redirect()->back()->withErrors(['Please enter amount in increments of $1000 only'])->withInput(['email'=>$request->email,'first_name'=>$request->first_name,'last_name'=>$request->last_name,'phone_number'=>$request->phone_number,'investment_amount'=>$request->investment_amount,'investment_period'=>$request->investment_period]);
            }
            $this->validate($request, [
                'first_name' => 'required',
                'last_name' =>'required',
                'email' => 'required',
                'phone_number' => 'required|numeric',
                'investment_amount' => 'required|numeric',
                'investment_period' => 'required',
            ]);
            if($project){
                if($project->eoi_button){
                    $eoi_data = ProjectEOI::create([
                        'project_id' => $request->project_id,
                        'user_id' => $user->id,
                        'user_name' => $request->first_name.' '.$request->last_name,
                        'user_email' => $request->email,
                        'phone_number' => $request->phone_number,
                        'investment_amount' => $request->investment_amount,
                        'invesment_period' => $request->investment_period,
                        'project_site' => url(),
                    ]);
                    $mailer->sendProjectEoiEmailToAdmins($project, $eoi_data);
                    $mailer->sendProjectEoiEmailToUser($project, $user_info);
                }
            }
            return redirect()->route('users.success.eoi');
        }
    }
    /**
     * authenticate user
     * @param  UserAuthRequest $request
     * @return view user show page
     */
    public function authenticate(UserAuthRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active'=>1], $request->remember)) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            if (Auth::user()->roles->contains('role', 'admin') || Auth::user()->roles->contains('role', 'master')) {
                $this->redirectTo = "/dashboard";
            }
            if($request->next){
                if( strpos( $request->next, '?id=' ) !== false ){
                    $this->redirectTo = "/".$request->next."&source=eoi";
                }else{
                    $this->redirectTo = "/".$request->next;
                }
            }
            elseif($request->redirectNotification){
                $this->redirectTo = "/users/".Auth::User()->id."/notification";
            }
            else{
                $this->redirectTo = "/#projects";
            }
            Session::flash('loginaction', 'success.');
            return redirect($this->redirectTo);
        }
        if (Auth::viaRemember()) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            return redirect()->route($this->redirectPath());
        }
        $user = User::whereEmail($request->email)->first();
        if($user) {
            if ($user->active) {
                return redirect()->route('users.login')->withInput($request->only('email', 'remember'))->withMessage('<p class="alert alert-danger text-center">email and password combination is wrong</p>');
            } else {
                return redirect()->route('users.login')->withInput($request->only('email', 'remember'))->withMessage('<p class="alert alert-danger text-center">User is not active, please activate user.</p>');
            }
        }
        $user_incomplete = UserRegistration::whereEmail($request->email)->first();
        if($user_incomplete) {
            if (!$user_incomplete->active) {
                return redirect()->route('users.login')->withInput($request->only('email', 'remember'))->withMessage('<p class="alert alert-danger text-center">This email is registered but you dont seem to have activated yourself.<br> We have sent an activation link to this email, please click on the link to activate yourself and then you will be able to access the site <br><br> or <a href="/registrations/resend?email='.$request->email.'">click here to resend activation link</a></p>');
            } else {
                return redirect()->route('users.login')->withInput($request->only('email', 'remember'))->withMessage('<p class="alert alert-danger text-center">This email is registered but you dont seem to have activated yourself.<br> We have sent an activation link to this email, please click on the link to activate yourself and then you will be able to access the site <br><br> or <a href="/registrations/resend?email='.$request->email.'">click here to resend activation link</a></p>');
            }
        }
        if($request->eoiLogin == 'eoiLogin'){
            return redirect()->back()->withInput($request->only('email', 'remember'))->withMessage('<p class="alert alert-warning text-center">This email is not registered, please sign up.</p>')->with('error_code', 5);
        }
        return redirect()->route('users.login')->withInput($request->only('email', 'remember'))->withMessage('<p class="alert alert-warning text-center">This email is not registered, please sign up.</p>');
    }

    public function activate($token)
    {
        $user = User::whereActivationToken($token)->firstOrFail();
        if($user->active) {
            $status = $user->update(['active'=> 0, 'activated_on'=>Carbon::now()]);
            return redirect()->route('users.login')->withMessage('<p class="alert alert-info text-center">User Already Activated</p>');
        }
        $user->active = true;
        $user->activated_on = Carbon::now();
        $user->save();
        return redirect()->route('users.login')->withMessage('<p class="alert alert-success text-center">Activation Successful! Login to see the opportunities, you recieved $25 in your credit.</p>');
    }
}
