<?php

namespace App\Http\Controllers\Auth;
use Session;
// namespace App\Http\Controllers;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
// use Laravel\Socialite\Facades\Socialite;
use App\SocialAccountService;
use App\SocialAccountService1;
use App\SocialAccountService2;
use App\SocialAccountService3;
use Socialite;
use App\Color;
use Carbon\Carbon;
use App\Credit;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        $redirect_url = url().'/auth/facebook/callback';
        \Config::set('services.facebook.redirect',$redirect_url);
        return Socialite::driver('facebook')->redirect();
    }
    public function redirectToProvider1()
    {
        $redirect_url = url().'/auth/linkedin/callback';
        \Config::set('services.linkedin.redirect',$redirect_url);
        return Socialite::driver('linkedin')->redirect();
    }
    public function redirectToProvider2()
    {
        $redirect_url = url().'/auth/twitter/callback';
        \Config::set('services.twitter.redirect',$redirect_url);
        return Socialite::driver('twitter')->redirect();
    }
    public function redirectToProvider3()
    {
        $redirect_url = url().'/auth/google/callback';
        \Config::set('services.google.redirect',$redirect_url);
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $service,AppMailer $mailer,Request $request)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        if(! $request->input('code')){
            return redirect('users/login')->withMessage('<p class="alert alert-danger text-center"> Login failed: '.$request->input('error').'</p>');
        }
        $redirect_url = url().'/auth/facebook/callback';
        \Config::set('services.facebook.redirect',$redirect_url);
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user(),$mailer);
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete) {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete;
        }
        else {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->daily_login_bonus_konkrete;
        };
        $loginBonus = 0;
        if($user->last_login){
            if(!$user->last_login->gt(\Carbon\Carbon::now()->subDays(1))){          
                $loginBonus = rand(1, $daily_bonus_konkrete);          
                Credit::create([
                    'user_id' => $user->id,
                    'amount' => $loginBonus,
                    'type' => 'Daily login bonus',
                    'project_site' => url(),
                    'currency' => 'konkrete'
                    ]);
            }
        }
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        // $mailer->sendRegistrationNotificationAdmin($user);
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        Session::flash('loginaction', 'success.');
        if($user->phone_number != ''){
            $color = Color::where('project_site',url())->first();
            return view('users.show',compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
        else{
            $color = Color::where('project_site',url())->first();
            return view('users.fbedit', compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
    }
    public function handleProviderCallback1(SocialAccountService1 $service,AppMailer $mailer, Request $request)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        if(! $request->input('code')){
            return redirect('users/login')->withMessage('<p class="alert alert-danger text-center"> Login failed: '.$request->input('error').'</p>');
        }
        $redirect_url = url().'/auth/linkedin/callback';
        \Config::set('services.linkedin.redirect',$redirect_url);
        $user = $service->createOrGetUser(Socialite::driver('linkedin')->user(),$mailer);
        $loginBonus = 0;
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete) {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete;
        }
        else {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->daily_login_bonus_konkrete;
        };
        if($user->last_login){
            if(!$user->last_login->gt(\Carbon\Carbon::now()->subDays(1))){          
                $loginBonus = rand(1, $daily_bonus_konkrete);          
                Credit::create([
                    'user_id' => $user->id,
                    'amount' => $loginBonus,
                    'type' => 'Daily login bonus',
                    'project_site' => url(),
                    'currency' => 'konkrete'
                    ]);
            }
        }
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        Session::flash('loginaction', 'success.');
        if($user->phone_number != ''){
            $color = Color::where('project_site',url())->first();
            return view('users.show',compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
        else{
            $color = Color::where('project_site',url())->first();
            return view('users.fbedit', compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
    }
    public function handleProviderCallback2(SocialAccountService2 $service,AppMailer $mailer)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        $redirect_url = url().'/auth/twitter/callback';
        \Config::set('services.twitter.redirect',$redirect_url);
        $user = $service->createOrGetUser(Socialite::driver('twitter')->user(),$mailer);
        $loginBonus = 0;
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete) {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete;
        }
        else {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->daily_login_bonus_konkrete;
        };
        if($user->last_login){
            if(!$user->last_login->gt(\Carbon\Carbon::now()->subDays(1))){          
                $loginBonus = rand(1, $daily_bonus_konkrete);          
                Credit::create([
                    'user_id' => $user->id,
                    'amount' => $loginBonus,
                    'type' => 'Daily login bonus',
                    'project_site' => url(),
                    'currency' => 'konkrete'
                    ]);
            }
        }
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        if($user->phone_number != ''){
            $color = Color::where('project_site',url())->first();
            return view('users.show',compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
        else{
            $color = Color::where('project_site',url())->first();
            return view('users.fbedit', compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
    }
    public function handleProviderCallback3(SocialAccountService3 $service,AppMailer $mailer)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        $redirect_url = url().'/auth/google/callback';
        \Config::set('services.google.redirect',$redirect_url);
        $user = $service->createOrGetUser(Socialite::driver('google')->user(),$mailer);
        $loginBonus = 0;
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete) {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->daily_login_bonus_konkrete;
        }
        else {
            $daily_bonus_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->daily_login_bonus_konkrete;
        };
        if($user->last_login){
            if(!$user->last_login->gt(\Carbon\Carbon::now()->subDays(1))){          
                $loginBonus = rand(1, $daily_bonus_konkrete);          
                Credit::create([
                    'user_id' => $user->id,
                    'amount' => $loginBonus,
                    'type' => 'Daily login bonus',
                    'project_site' => url(),
                    'currency' => 'konkrete'
                    ]);
            }
        }
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        $color = Color::where('project_site',url())->first();
        Session::flash('loginaction', 'success.');
        if($user->phone_number != ''){
            return view('users.show',compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
        else{
            return view('users.fbedit', compact('user','color'))->withCookie(cookie('login_bonus', $loginBonus, 1));
        }
    }
// }

// class AuthController extends Controller
// {
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * redirection path after signup
     * @var string
     */
    protected $redirectTo = '/auth/login';


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone_number' => 'required|min:10|max:15',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => str_slug($data['first_name'].' '.$data['last_name'].' '.rand(1, 999)),
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => bcrypt($data['password']),
            ]);
        return redirect('/auth/login');
    }
}
