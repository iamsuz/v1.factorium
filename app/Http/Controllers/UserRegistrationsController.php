<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Color;
use Validator;
use App\Invite;
use App\Credit;
use Carbon\Carbon;
use App\Http\Requests;
use App\UserRegistration;
use App\Mailers\AppMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intercom\IntercomBasicAuthClient;
use App\Http\Requests\UserAuthRequest;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class UserRegistrationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppMailer $mailer)
    {
        $color = Color::where('project_site',url())->first();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6|max:60',
            'role'=>'required',
            'registration_site'=>'required'
            ]);
        $validator1 = Validator::make($request->all(), [
            'email' => 'unique:users,email||unique:user_registrations,email',
            ]);
        if ($validator->fails()) {
            return redirect('/users/create')
            ->withErrors($validator)
            ->withInput();
        }
        if($validator1->fails()){
            $res1 = User::where('email', $request->email)->where('registration_site', url())->first();
            $res2 = UserRegistration::where('email', $request->email)->where('registration_site', url())->first();
            if(!$res1 && !$res2){
                $originSite="";
                if($user=User::where('email', $request->email)->first()){
                    $originSite = $user->registration_site;
                }
                if($userReg=UserRegistration::where('email', $request->email)->first()){
                    $originSite = $userReg->registration_site;
                }
                $errorMessage = 'This email is already registered on '.$originSite.' which is an EstateBaron.com powered site, you can use the same login id and password on this site.';
                if($request->eoiReg == 'eoiReg'){
                    return redirect($request->next)->withErrors(['email'=> $errorMessage])->withInput();
                }
                return redirect('/users/create')->withErrors(['email'=> $errorMessage])->withInput();
            }
            else{
                if($request->eoiReg == 'eoiReg'){
                    return redirect($request->next)->withErrors($validator1)->withInput();
                }
                return redirect('/users/create')
                    ->withErrors($validator1)
                    ->withInput();
            }
        }
        // dd($request);
        if($request->eoiReg == 'eoiReg'){
            $eoi_token = mt_rand(100000, 999999);
            $user = UserRegistration::create($request->all()+['eoi_token'=>$eoi_token]);
            $mailer->sendRegistrationConfirmationTo($user);
            return redirect()->back()->with('success_code', 6);
        }
        else{
            dd('outside');
            $user = UserRegistration::create($request->all());
            $mailer->sendRegistrationConfirmationTo($user);
        }

        // $intercom = IntercomBasicAuthClient::factory(array(
        //     'app_id' => 'refan8ue',
        //     'api_key' => '3efa92a75b60ff52ab74b0cce6a210e33e624e9a',
        //     ));
        // $intercom->createUser(array(
        //     "email" => $user->email,
        //     "custom_attributes" => array(
        //         "active" => $user->active,
        //         "token" => $user->token,
        //         "role" => $user->role
        //         ),
        //     ));
        return view('users.registrationSubmitted',compact('color'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function activate($token)
    {
        $color = Color::where('project_site',url())->first();
        $user = UserRegistration::whereToken($token)->firstOrFail();
        if($user->active) {
            // return redirect()->route('users.login')->withMessage('<p class="alert alert-info text-center">User Already Activated</p>');
        }
        $user->active = true;
        $user->activated_on = Carbon::now();
        $user->save();
        return view('users.details', compact('user','color'))->withMessage('Successfully Activated, please fill the details');
    }

    public function resend_activation_link(Request $request, AppMailer $mailer)
    {
        $email = $request->email;
        $user = UserRegistration::whereEmail($email)->firstOrFail();
        $mailer->sendRegistrationConfirmationTo($user);
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully resent an activation link.</p>');
    }

    public function storeDetails(Request $request, AppMailer $mailer)
    {
        $cookies = \Cookie::get();
        $referrer = isset($cookies['referrer']) ? $cookies['referrer'] : "";
        $this->validate($request, [
            'first_name' => 'required|min:1|max:50',
            'last_name' => 'required|min:1|max:50',
            'phone_number' => 'required|numeric',
            'token'=>'required',
            ]);

        $userReg = UserRegistration::whereToken($request->token)->firstOrFail();
        $color = Color::where('project_site',url())->first();
        if (!$request['username']) {
            $request['username']= str_slug($request->first_name.' '.$request->last_name.' '.rand(1, 9999));
        }
        $request['email'] = $userReg->email;
        $request['password'] = bcrypt($userReg->password);
        $request['active'] = true;
        $request['activated_on'] = $userReg->activated_on;
        $request['registration_site'] = $userReg->registration_site;
        // dd($userReg);
        $role = Role::whereRole($userReg->role)->firstOrFail();
        $roleText = $userReg->role;

        $user = User::create($request->all());
        $time_now = Carbon::now();
        $user->roles()->attach($role);
        $credit = Credit::create(['user_id'=>$user->id, 'amount'=>50, 'type'=>'sign up']);
        $password = $userReg->password;
        $userReg->delete();

        // intercom create user
        // $intercom = IntercomBasicAuthClient::factory(array(
        //     'app_id' => 'refan8ue',
        //     'api_key' => '3efa92a75b60ff52ab74b0cce6a210e33e624e9a',
        //     ));
        // $intercom->createUser(array(
        //     "id" => $user->id,
        //     "user_id" => $user->id,
        //     "email" => $user->email,
        //     "name" => $user->first_name.' '.$user->last_name,
        //     "custom_attributes" => array(
        //         "last_name" => $user->last_name,
        //         "active" => $user->active,
        //         "phone_number" => $user->phone_number,
        //         "activated_on_at" => $user->activated_on->timestamp,
        //         "role" => $roleText
        //         ),
        //     ));
        $mailer->sendRegistrationNotificationAdmin($user,$referrer);
        if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            // return view('users.registrationFinish', compact('user','color'));
            return redirect('/#projects')->withCookie(\Cookie::forget('referrer'));
        }
    }

    public function acceptedInvitation($token)
    {
        $color = Color::where('project_site',url())->first();
        $invite = Invite::whereToken($token)->firstOrFail();
        if($invite->accepted){
            return view('users.alreadyAcceptedInvitation', compact('token','color'));
        }
        // $invite->update(['accepted'=>1,'accepted_on'=>Carbon::now()]);
        // $invite = Credit::create(['user_id'=>$invite->user_id, 'invite_id'=>$invite->id, 'amount'=>25, 'type'=>'accepted invite']);

        return view('users.acceptedInvitation', compact('token','color'));
    }


    public function storeDetailsInvite(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|alpha_dash|min:1|max:50',
            'last_name' => 'required|alpha_dash|min:1|max:50',
            'phone_number' => 'required',
            'password' => 'required',
            'token'=>'required',
            ]);

        $userReg = Invite::whereToken($request->token)->firstOrFail();
        $color = Color::where('project_site',url())->first();
        if (!$request['username']) {
            $request['username']= str_slug($request->first_name.' '.$request->last_name.' '.rand(1, 9999));
        }
        $request['email'] = $userReg->email;
        $request['active'] = true;
        $request['activated_on'] = $userReg->accepted_on;
        $role = Role::whereRole('investor')->firstOrFail();

        $user = User::create($request->all());
        $time_now = Carbon::now();
        $user->roles()->attach($role);
        $credit = Credit::create(['user_id'=>$user->id, 'amount'=>50, 'type'=>'sign up']);

        $invite = Invite::whereToken($request->token)->firstOrFail();
        $invite->update(['accepted'=>1,'accepted_on'=>Carbon::now()]);
        $mailer->sendRegistrationNotificationAdmin($user);
        //intercom create user
        // $intercom = IntercomBasicAuthClient::factory(array(
        //     'app_id' => 'refan8ue',
        //     'api_key' => '3efa92a75b60ff52ab74b0cce6a210e33e624e9a',
        //     ));
        // $intercom->createUser(array(
        //     "id" => $user->id,
        //     "user_id" => $user->id,
        //     "email" => $user->email,
        //     "name" => $user->first_name.' '.$user->last_name,
        //     "custom_attributes" => array(
        //         "last_name" => $user->last_name,
        //         "active" => $user->active,
        //         "phone_number" => $user->phone_number,
        //         "activated_on_at" => $user->activated_on->timestamp
        //         ),
        //     ));
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active'=>1], $request->remember)) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            return view('users.registrationFinish', compact('user','color'));
        }
    }

    public function thanks()
    {
        $color = Color::where('project_site',url())->first();
        return view('users.registrationFinish',compact('color'));
    }
}
