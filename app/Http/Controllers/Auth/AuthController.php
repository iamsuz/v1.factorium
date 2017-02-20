<?php

namespace App\Http\Controllers\Auth;
// namespace App\Http\Controllers;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Mailers\AppMailer;
// use Laravel\Socialite\Facades\Socialite;
use App\SocialAccountService;
use App\SocialAccountService1;
use App\SocialAccountService2;
use App\SocialAccountService3;
use Socialite;
use App\Color;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirectUrl('https://xtra.estatebaron.com/auth/facebook/callback')->redirect();
    }
    public function redirectToProvider1()
    {
        return Socialite::driver('linkedin')->redirect();
    }
    public function redirectToProvider2()
    {
        return Socialite::driver('twitter')->redirect();
    }
    public function redirectToProvider3()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $service,AppMailer $mailer)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user(),$mailer);
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        // $mailer->sendRegistrationNotificationAdmin($user);
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        if($user->phone_number != ''){
            $color = Color::where('project_site',url())->first();
            return view('users.show',compact('user','color'));
        }
        else{
            $color = Color::where('project_site',url())->first();
            return view('users.fbedit', compact('user','color'));
        }
    }
    public function handleProviderCallback1(SocialAccountService1 $service,AppMailer $mailer)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        $user = $service->createOrGetUser(Socialite::driver('linkedin')->user(),$mailer);
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        if($user->phone_number != ''){
            return view('users.show',compact('user'));
        }
        else{
            return view('users.fbedit', compact('user'));
        }
    }
    public function handleProviderCallback2(SocialAccountService2 $service,AppMailer $mailer)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        $user = $service->createOrGetUser(Socialite::driver('twitter')->user(),$mailer);
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        if($user->phone_number != ''){
            return view('users.show',compact('user'));
        }
        else{
            return view('users.fbedit', compact('user'));
        }
    }
    public function handleProviderCallback3(SocialAccountService3 $service,AppMailer $mailer)
    {
        // $user = Socialite::driver('facebook')->user();
        // $user->token;
        $user = $service->createOrGetUser(Socialite::driver('google')->user(),$mailer);
        // dd($user);
        // Auth::loginUsingId($fan->getAuthIdentifier());
        auth()->loginUsingId($user->id);
        // if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
        //     Auth::user()->update(['last_login'=> Carbon::now()]);
        //     return view('users.registrationFinish', compact('user'));
        // }
        // dd($user->phone_number);
        if($user->phone_number != ''){
            return view('users.show',compact('user'));
        }
        else{
            return view('users.fbedit', compact('user'));
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
