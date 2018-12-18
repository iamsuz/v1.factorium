<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Role;
use App\Color;
use Validator;
use App\Invite;
use App\Credit;
use App\Project;
use App\ProjectEOI;
use Carbon\Carbon;
use App\Http\Requests;
use App\InvestingJoint;
use App\UserRegistration;
use App\OfferRegistration;
use App\InvestmentInvestor;
use App\Mailers\AppMailer;
use App\Jobs\SendReminderEmail;
use App\WholesaleInvestment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intercom\IntercomBasicAuthClient;
use App\Http\Requests\UserAuthRequest;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendInvestorNotificationEmail;
use App\Jobs\SendDeveloperNotificationEmail;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Response;
use ReCaptcha\ReCaptcha;

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
            'role'=>'required'
        ]);
        $validator1 = Validator::make($request->all(), [
            'email' => 'unique:users,email||unique:user_registrations,email',
        ]);
        if ($validator->fails()) {
            return redirect('/users/create')
            ->withErrors($validator)
            ->withInput();
        }

        // Validate captcha only if the form has captcha feature
        if($request->input('g-recaptcha-response') !== null) {
            $validator2 = Validator::make($request->all(), [
                'g-recaptcha-response' => 'required'
            ]);
            if ($validator2->fails()) {
                return redirect('/users/create')
                ->withErrors($validator2)
                ->withInput();
            }

            // Verify Captcha
            $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
            $capResponse = $recaptcha->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
            if(!$capResponse->isSuccess()) {
                return redirect('/users/create')->withErrors(['g-recaptcha-response'=> 'Recaptcha timeout or duplicate.'])->withInput();
            }
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
                    return redirect()->back()->withErrors(['email'=> $errorMessage])->withInput();
                }
                return redirect('/users/create')->withErrors(['email'=> $errorMessage])->withInput();
            }
            else{
                $errorMessage = 'This email is already registered but seems its not activated please activate email';
                if($request->eoiReg == 'eoiReg'){
                    if(!$request->next){
                        return redirect()->back()->withMessage('<p>This email is already registered but seems its not activated please activate email</p>');
                    }
                    return redirect($request->next)->withMessage('<p>This email is already registered but seems its not activated please activate email</p>');
                }
                return redirect('/users/create')
                ->withErrors($validator1)
                ->withInput();
            }
        }
        if($request->has('ref'))
        {
            $ref = request()->ref;
            $request->request->add(['referral_code' => Request()->ref]);
            $user = UserRegistration::create($request->all());
            $mailer->sendRegistrationConfirmationTo($user,$ref);
        }
        elseif($request->eoiReg == 'eoiReg'){
            $ref = false;
            $color = Color::where('project_site',url())->first();
            $eoi_token = mt_rand(100000, 999999);
            $user = UserRegistration::create($request->all()+['eoi_token'=>$eoi_token]);
            $mailer->sendRegistrationConfirmationTo($user,$ref);
            $type = 'eoi';
            // return view('users.registerCode',compact('color','type'));
            return redirect()->route('users.register.view.code')->with(['color'=>$color,'type'=>$type]);
        }
        elseif($request->offerReg == 'offerReg'){
            $ref =false;
            $color = Color::where('project_site',url())->first();
            $offerToken = mt_rad(100000, 999999);
            $user = UserRegistration::create($request->all()+['offerToken' => $offerToken]);
            $mailer->sendRegistrationConfirmationTo($user,$ref);
            return view('users.registerCode',compact('color'));
        }
        else{
            $ref = false;
            $user = UserRegistration::create($request->all());
            $mailer->sendRegistrationConfirmationTo($user,$ref);
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

    public function offerRegistrationCode(Request $request,$id,AppMailer $mailer)
    {
        $color = Color::where('project_site',url())->first();
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'role'=>'required'
        ]);
        $validator1 = Validator::make($request->all(), [
            'email' => 'unique:users,email||unique:user_registrations,email',
        ]);
        if ($validator->fails()) {
            return redirect()
            ->back()
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
                return redirect()->back()->withErrors(['email'=> $errorMessage])->withInput();
            }
            else{
                $errorMessage = 'This email is already registered but seems its not activated please activate email';
                return redirect()->back()->withMessage('This email is already registered but seems its not activated please activate email');
            }
        }
        $project = Project::findOrFail($id);
        if($project && $request->first_name !=''){
            $ref =false;
            $color = Color::where('project_site',url())->first();
            $offerToken = mt_rand(100000, 999999);
            $user = UserRegistration::create($request->all()+['eoi_token' => $offerToken,'registration_site'=>url(),'phone_number'=>$request->phone]);
            if($user){
                $offerData = '';
                $i = 0;
                while($offerData == '' && $i != 5){
                    $offerData = OfferRegistration::create($request->all()+['user_registration_id'=>$user->id,'project_id'=>$project->id,'investment_id'=>$project->investment->id,'joint_fname'=>$request->joint_investor_first,'joint_lname'=>$request->joint_investor_last,'trust_company'=>$request->investing_company_name]);
                    $i = $i+1;
                }
                if($offerData != ''){
                    $mailer->sendRegistrationConfirmationTo($user,$ref);
                    $type = 'offer';
                    return $offerData;
                }else{
                    // $mailer->sendApplicationRegistrationFailTo($request,$user);
                    return \Response::json(['error' => 'Sorry! We were not able to process the investment','data'=>$offerData], 404);
                }
            }
        }
        return Response::json(['error' => 'Sorry! We were not able to process the investment'], 404);
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
    }

    public function userRegisterLoginFromOfferForm(Request $request, $id, AppMailer $mailer) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'role'=>'required',
            'g-recaptcha-response' => 'required'
        ]);
        $validator1 = Validator::make($request->all(), [
            'email' => 'unique:users,email||unique:user_registrations,email',
        ]);
        if ($validator->fails()) {
            return Response::json(['status' => false, 'message' => $validator->errors()->first()]);
        }

        // Verify Captcha
        $recaptcha = new ReCaptcha(env('CAPTCHA_SECRET'));
        $capResponse = $recaptcha->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);
        if(!$capResponse->isSuccess()) {
            return Response::json(['status' => false, 'message'=> 'Recaptcha timeout or duplicate.']);
        }

        if($validator1->fails()){
            $activatedUser = User::where('email', $request->email)->first();
            $nonActivatedUser = UserRegistration::where('email', $request->email)->first();
            
            if($activatedUser) {  // If user email is registered.

                if($nonActivatedUser)
                    $nonActivatedUser->delete();    // Account is already verified, so deleted from user_registration table

                if($activatedUser->active) {    // User is active
                    if(Auth::attempt(['email' => $request->email, 'password' => $request['password'], 'active'=>1], $request->remember)) {
                        return Response::json(['status' => true, 'message' => 'The email id is already registered. So performed login with given password.']);
                    } 
                    else {
                        return Response::json(['status' => false, 'message' => 'The email id is already registered. The login also failed with the given password. Please use correct password for this email account.', 'next_redirect' => 'login']);
                    }
                } 
                else {      // User is inactive
                    return Response::json(['status' => false, 'message' => 'The email id is already registered and is deactivated.']);
                }
            }
            else if(!$activatedUser && $nonActivatedUser) {     // If user email is registered but is not verified yet.
                $nonActivatedUser->delete();
            }   
        }

        $passwordString = $request['password'];
        $this->createNewUser($request);     // Create new user with request details

        // $mailer->sendRegistrationNotificationAdmin($user,$referrer);        
        if (Auth::attempt(['email' => $request->email, 'password' => $passwordString, 'active'=>1], $request->remember)) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            
            return Response::json(['status' => true, 'message' => 'Login Successfull']);
        }
    }

    /**
     * User Creation from EOI and Offer forms
     * 
     * This method creates the new active user in users table
     * to support EOI and Offer forms submission for guest users.
     * 
     * @param $request Contains Request details from EOI or offer form.
     * @return void
     */
    public function createNewUser(Request $request) {
        if (!$request['username']) {
            $request['username']= str_slug($request->first_name.' '.$request->last_name.' '.rand(1, 9999));
        }
        $request['phone_number'] = $request['phone'];
        $request['password'] = bcrypt($request['password']);
        $request['active'] = true;
        $request['activated_on'] = Carbon::now();;
        $request['registration_site'] = url();

        $role = Role::whereRole($request['role'])->firstOrFail();
        $roleText = $request['role'];

        $user = User::create($request->all());
        $time_now = Carbon::now();
        $user->roles()->attach($role);
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete) {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete;
        }
        else {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->user_sign_up_konkrete;
        };
        $credit = Credit::create(['user_id'=>$user->id, 'amount'=>$signup_konkrete, 'type'=>'sign up', 'currency'=>'konkrete', 'project_site' => url()]);
    }

    public function registerCodeView()
    {
        $color = Color::where('project_site',url())->first();
        $type = 'offer';
        return view('users.registerCode',compact('color','type'));
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

    public function activate($token,Request $request)
    {
        $color = Color::where('project_site',url())->first();
        $user = UserRegistration::whereToken($token)->firstOrFail();
        if($user->active) {
            // return redirect()->route('users.login')->withMessage('<p class="alert alert-info text-center">User Already Activated</p>');
        }
        if($request->has('ref'))
        {
            $request->session()->put('ref',request()->ref);
        }
        $user->active = true;
        $user->activated_on = Carbon::now();
        $user->save();
        $siteConfiguration = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr();

        return view('users.details', compact('user','color', 'siteConfiguration'))->withMessage('Successfully Activated, please fill the details');
    }

    public function resend_activation_link(Request $request, AppMailer $mailer)
    {
        $ref = false;
        $email = $request->email;
        $user = UserRegistration::whereEmail($email)->firstOrFail();
        $mailer->sendRegistrationConfirmationTo($user,$ref);
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
            'password' => 'required|min:6|max:60',
            'token'=>'required',
        ]);

        $userReg = UserRegistration::whereToken($request->token)->firstOrFail();
        $color = Color::where('project_site',url())->first();
        if (!$request['username']) {
            $request['username']= str_slug($request->first_name.' '.$request->last_name.' '.rand(1, 9999));
        }
        $oldPassword = $request->password;
        $request['email'] = $userReg->email;
        $request['password'] = bcrypt($request->password);
        $request['active'] = true;
        $request['activated_on'] = $userReg->activated_on;
        $request['registration_site'] = $userReg->registration_site;

        // dd($userReg);
        $role = Role::whereRole($userReg->role)->firstOrFail();
        $roleText = $userReg->role;

        $user = User::create($request->all());
        $time_now = Carbon::now();
        $user->roles()->attach($role);
        $password = $oldPassword;
        $userReg->delete();
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete) {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete;
        }
        else {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->user_sign_up_konkrete;
        };
        if ($request->session()->has('ref')) {
            event(new \App\Events\UserReferred(request()->session()->get('ref'), $user));
        }else{
            $credit = Credit::create(['user_id'=>$user->id, 'amount'=>$signup_konkrete, 'type'=>'sign up', 'currency'=>'konkrete', 'project_site' => url()]);
        }
        $mailer->sendRegistrationNotificationAdmin($user,$referrer);
        if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            // return view('users.registrationFinish', compact('user','color'));
            return redirect('/#projects')->withCookie(\Cookie::forget('referrer'));
        }
    }

    public function registrationCode(Request $request,AppMailer $mailer)
    {
        $validator = Validator::make($request->all(), [
            'eoiCode' => 'required|numeric|digits:6',
        ]);
        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }
        $color = Color::where('project_site',url())->first();
        $userR = UserRegistration::where('eoi_token',$request->eoiCode)->first();
        if(!$userR){
            return redirect()->back()->withMessage('Code is Invalid, Please Ensure you enter 6 digit code which is sent on your Email')->withInput(['eoiCode'=>$request->eoiCode]);
        }
        $userR->active = true;
        $userR->activated_on = Carbon::now();
        $userR->save();
        $cookies = \Cookie::get();
        $referrer = isset($cookies['referrer']) ? $cookies['referrer'] : "";
        $userReg = $userR;
        $color = Color::where('project_site',url())->first();
        $request['first_name'] = $userReg->first_name;
        $request['last_name'] = $userReg->last_name;
        if (!$request['username']) {
            $request['username']= str_slug($request->first_name.' '.$request->last_name.' '.rand(1, 9999));
        }
        $request['phone_number'] = $userReg->phone_number;
        $request['email'] = $userReg->email;
        $request['password'] = bcrypt($userReg->password);
        $request['active'] = true;
        $request['activated_on'] = $userReg->activated_on;
        $request['registration_site'] = $userReg->registration_site;
        if($userReg->eoi_project != NULL){
            $request['project_id'] = $userReg->eoi_project;
            $request['eoi_project'] = $userReg->eoi_project;
            $request['investment_amount'] = $userReg->investment_amount;
            $request['investment_period'] = $userReg->investment_period;
        }else{
            $request['project_id'] = $userReg->offer_registration->project_id;
            $request['investment_amount'] = $userReg->offer_registration->amount_to_invest;
            $request['amount_to_invest'] = $userReg->offer_registration->amount_to_invest;
            $request['investing_as'] = $userReg->offer_registration->investing_as;
            $request['joint_investor_first_name'] = $userReg->offer_registration->joint_fname;
            $request['joint_investor_last_name'] = $userReg->offer_registration->joint_lname;
            $request['investing_company'] = $userReg->offer_registration->trust_company;
            $request['account_name'] = $userReg->offer_registration->account_name;
            $request['bsb'] = $userReg->offer_registration->bsb;
            $request['account_number'] = $userReg->offer_registration->account_number;
            $request['signature_data'] = $userReg->offer_registration->signature_data;
            $request['line_1'] = $userReg->offer_registration->line_1;
            $request['line_2'] = $userReg->offer_registration->line_2;
            $request['city'] = $userReg->offer_registration->city;
            $request['state'] = $userReg->offer_registration->state;
            $request['postal_code'] = $userReg->offer_registration->postal_code;
            $request['country'] = $userReg->offer_registration->country;
            $request['country_code'] = $userReg->offer_registration->country_code;
            $request['tfn'] = $userReg->offer_registration->tfn;
            $request['interested_to_buy'] = $userReg->offer_registration->interested_to_buy;
            $request['signature_data_type'] = $userReg->offer_registration->signature_data_type;
            $request['signature_type'] = $userReg->offer_registration->signature_type;
        }
        // dd($userReg);
        $role = Role::whereRole($userReg->role)->firstOrFail();
        $roleText = $userReg->role;

        $user = User::create($request->all());
        $time_now = Carbon::now();
        $user->roles()->attach($role);
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete) {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete;
        }
        else {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->user_sign_up_konkrete;
        };
        $credit = Credit::create(['user_id'=>$user->id, 'amount'=>$signup_konkrete, 'type'=>'sign up', 'currency'=>'konkrete', 'project_site' => url()]);
        $password = $userReg->password;
        if($userReg->eoi_project == NULL){
            $offerRegi = $userReg->offer_registration;
            $offerRegi->delete();
        }
        $userReg->delete();
        $mailer->sendRegistrationNotificationAdmin($user,$referrer);
        if (Auth::attempt(['email' => $request->email, 'password' => $password, 'active'=>1], $request->remember)) {
            Auth::user()->update(['last_login'=> Carbon::now()]);
            $project = Project::findOrFail($request->project_id);
            $user = Auth::user();
            $user_info = Auth::user();
            $min_amount_invest = $project->investment->minimum_accepted_amount;
            if((int)$request->investment_amount < (int)$min_amount_invest)
            {
                return redirect()->back()->withErrors(['The amount to invest must be at least $'.$min_amount_invest]);
            }
            if((int)$request->investment_amount % 100 != 0)
            {
                return redirect()->back()->withErrors(['Please enter amount in increments of $100 only'])->withInput(['email'=>$request->email,'first_name'=>$request->first_name,'last_name'=>$request->last_name,'phone_number'=>$request->phone_number,'investment_amount'=>$request->investment_amount,'investment_period'=>$request->investment_period]);
            }
            if($project){
                if($project->eoi_button && $request->eoi_project){
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
                    return redirect()->route('users.success.eoi');
                }else{
                    $project = Project::findOrFail($request->project_id);
                    $user = Auth::user();
                    // If application store request received from request form
                    if($request->investment_request_id)
                    {
                        $investmentRequest = InvestmentRequest::find($request->investment_request_id);
                        if($investmentRequest) {
                            if(\App\Helpers\SiteConfigurationHelper::isSiteAdmin()){
                                if($investmentRequest->project->project_site == url()) {
                                    $user = User::find($investmentRequest->user_id);
                                    $project = Project::find($investmentRequest->project_id);
                                }
                                else{
                                    return redirect()->back()->withErrors('Not Project Admin');
                                }
                            }
                            else{
                                return redirect()->back()->withErrors('Not Site Admin');
                            }
                        }
                        else {
                            return redirect()->back()->withErrors('Something went wrong');
                        }
                    }
                    $amount = floatval(str_replace(',', '', str_replace('A$ ', '', $request->amount_to_invest)));
                    $amount_5 = $amount*0.05; //5 percent of investment
                    if($user->idDoc != NULL){
                        $investingAs = $user->idDoc->get()->last()->investing_as;
                    }else{
                        $investingAs = $request->investing_as;
                    }
                    $user->investments()->attach($project, ['investment_id'=>$project->investment->id,'amount'=>$amount,'project_site'=>url(),'investing_as'=>$investingAs, 'signature_data'=>$request->signature_data, 'interested_to_buy'=>$request->interested_to_buy,'signature_data_type'=>$request->signature_data_type,'signature_type'=>$request->signature_type]);
                    $investor = InvestmentInvestor::get()->last();
                    if($user->idDoc != NULL && $user->idDoc->investing_as != 'Individual Investor'){
                        $investing_joint = new InvestingJoint;
                        $investing_joint->project_id = $project->id;
                        $investing_joint->investment_investor_id = $investor->id;
                        $investing_joint->joint_investor_first_name = $user->idDoc->joint_first_name;
                        $investing_joint->joint_investor_last_name = $user->idDoc->joint_last_name;
                        $investing_joint->investing_company = $user->idDoc->trust_or_company;
                        $investing_joint->account_name = $request->account_name;
                        $investing_joint->bsb = $request->bsb;
                        $investing_joint->account_number = $request->account_number;
                        $investing_joint->line_1 = $request->line_1;
                        $investing_joint->line_2 = $request->line_2;
                        $investing_joint->city = $request->city;
                        $investing_joint->state = $request->state;
                        $investing_joint->postal_code = $request->postal_code;
                        $investing_joint->country = $request->country;
                        $investing_joint->country_code = $request->country_code;
                        $investing_joint->tfn = $request->tfn;
                        $investing_joint->save();
                    }elseif($request->investing_as != 'Individual Investor'){
                        $investing_joint = new InvestingJoint;
                        $investing_joint->project_id = $project->id;
                        $investing_joint->investment_investor_id = $investor->id;
                        $investing_joint->joint_investor_first_name = $request->joint_investor_first_name;
                        $investing_joint->joint_investor_last_name = $request->joint_investor_last_name;
                        $investing_joint->investing_company = $request->investing_company;
                        $investing_joint->account_name = $request->account_name;
                        $investing_joint->bsb = $request->bsb;
                        $investing_joint->account_number = $request->account_number;
                        $investing_joint->line_1 = $request->line_1;
                        $investing_joint->line_2 = $request->line_2;
                        $investing_joint->city = $request->city;
                        $investing_joint->state = $request->state;
                        $investing_joint->postal_code = $request->postal_code;
                        $investing_joint->country = $request->country;
                        $investing_joint->country_code = $request->country_code;
                        $investing_joint->tfn = $request->tfn;
                        $investing_joint->save();
                    }
                    else{
                        $user->update($request->all());
                    }
                    $investor_joint = InvestingJoint::get()->last();
                    if($user->idDoc != NULL && $user->idDoc->investing_as == 'Joint Investor'){
                        $user_investment_doc = new UserInvestmentDocument(['type'=>'joint_investor', 'filename'=>$user->idDoc->get()->last()->joint_id_filename, 'path'=>$user->idDoc->get()->last()->joint_id_path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->get()->last()->joint_id_extension,'user_id'=>$user->id]);
                        $project->investmentDocuments()->save($user_investment_doc);
                        $user_ind_investment_doc = new UserInvestmentDocument(['type'=>'normal_name', 'filename'=>$user->idDoc->get()->last()->filename, 'path'=>$user->idDoc->get()->last()->path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->get()->last()->extension,'user_id'=>$user->id]);
                        $project->investmentDocuments()->save($user_ind_investment_doc);
                    }
                    if($user->idDoc != NULL && $user->idDoc->investing_as == 'Individual Investor'){
                        $user_investment_doc = new UserInvestmentDocument(['type'=>'normal_name', 'filename'=>$user->idDoc->get()->last()->filename, 'path'=>$user->idDoc->get()->last()->path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->get()->last()->extension,'user_id'=>$user->id]);
                        $project->investmentDocuments()->save($user_investment_doc);
                    }
                    if($user->idDoc != NULL && $user->idDoc->investing_as == 'Trust or Company'){
                        $user_investment_doc = new UserInvestmentDocument(['type'=>'trust_or_company', 'filename'=>$$user->idDoc->get()->last()->filename, 'path'=>$user->idDoc->get()->last()->path,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$user->idDoc->get()->last()->extension,'user_id'=>$user->id]);
                        $project->investmentDocuments()->save($user_investment_doc);
                    }
                    if($request->hasFile('joint_investor_id_doc'))
                    {
                        $destinationPath = 'assets/users/'.$user->id.'/investments/'.$investor->id.'/'.$request->joint_investor_first.'_'.$request->joint_investor_last.'/';
                        $filename = $request->file('joint_investor_id_doc')->getClientOriginalName();
                        $fileExtension = $request->file('joint_investor_id_doc')->getClientOriginalExtension();
                        $request->file('joint_investor_id_doc')->move($destinationPath, $filename);
                        $user_investment_doc = new UserInvestmentDocument(['type'=>'joint_investor', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$fileExtension,'user_id'=>$user->id]);
                        $project->investmentDocuments()->save($user_investment_doc);
                    }
                    if($request->hasFile('trust_or_company_docs'))
                    {
                        $destinationPath = 'assets/users/'.$user->id.'/investments/'.$investor->id.'/'.$request->investing_company_name.'/';
                        $filename = $request->file('trust_or_company_docs')->getClientOriginalName();
                        $fileExtension = $request->file('trust_or_company_docs')->getClientOriginalExtension();
                        $request->file('trust_or_company_docs')->move($destinationPath, $filename);
                        $user_investment_doc = new UserInvestmentDocument(['type'=>'trust_or_company', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$fileExtension,'user_id'=>$user->id]);
                        $project->investmentDocuments()->save($user_investment_doc);

                    }
                    if($request->hasFile('user_id_doc'))
                    {
                        $destinationPath = 'assets/users/'.$user->id.'/investments/'.$investor->id.'/normal_name/';
                        $filename = $request->file('user_id_doc')->getClientOriginalName();
                        $fileExtension = $request->file('user_id_doc')->getClientOriginalExtension();
                        $request->file('user_id_doc')->move($destinationPath, $filename);
                        $user_investment_doc = new UserInvestmentDocument(['type'=>'normal_name', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'project_id'=>$project->id,'investing_joint_id'=>$investor_joint->id,'investment_investor_id'=>$investor->id,'extension'=>$fileExtension,'user_id'=>$user->id]);
                        $project->investmentDocuments()->save($user_investment_doc);

                    }
                //Save wholesale project input fields
                    if(!$project->retail_vs_wholesale) {
                        $wholesale_investor = WholesaleInvestment::get()->last();{
                            $wholesale_investing = new WholesaleInvestment;
                            $wholesale_investing->project_id = $project->id;
                            $wholesale_investing->investment_investor_id = $investor->id;
                            $wholesale_investing->wholesale_investing_as = $request->wholesale_investing_as;
                            if($request->wholesale_investing_as === 'Wholesale Investor (Net Asset $2,500,000 plus)'){
                                $wholesale_investing->accountant_name_and_firm = $request->accountant_name_firm_txt;
                                $wholesale_investing->accountant_professional_body_designation = $request->accountant_designation_txt;
                                $wholesale_investing->accountant_email = $request->accountant_email_txt;
                                $wholesale_investing->accountant_phone = $request->accountant_phone_txt;
                            }
                            elseif($request->wholesale_investing_as === 'Sophisticated Investor'){
                                $wholesale_investing->experience_period = $request->experience_period_txt;
                                $wholesale_investing->equity_investment_experience_text = $request->equity_investment_experience_txt;
                                $wholesale_investing->unlisted_investment_experience_text = $request->unlisted_investment_experience_txt;
                                $wholesale_investing->understand_risk_text = $request->understand_risk_txt;
                            }
                            $wholesale_investing->save();
                        }
                    }
                // Mark request form link expired
                    if($request->investment_request_id){
                        InvestmentRequest::find($request->investment_request_id)->update([
                            'is_link_expired' => 1
                        ]);
                    }
                // Create PDF of Application form
                // $pdfBasePath = '/app/application/application-'.$investor->id.'-'.time().'.pdf';
                // $pdfPath = storage_path().$pdfBasePath;
                // $pdf = PDF::loadView('pdf.application', ['project' => $project, 'investment' => $investor, 'user' => $user]);
                // $pdf->save($pdfPath);
                // $investor->application_path = $pdfBasePath;
                    $investor->save();

                    $this->dispatch(new SendInvestorNotificationEmail($user,$project, $investor));
                    $this->dispatch(new SendReminderEmail($user,$project,$investor));

                    return view('projects.gform.thankyou', compact('project', 'user', 'amount_5', 'amount'));
                }

            }

        }
        return view('users.details', compact('user','color'))->withMessage('Successfully Activated, please fill the details');
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
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete) {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete;
        }
        else {
            $signup_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->user_sign_up_konkrete;
        };
        $credit = Credit::create(['user_id'=>$user->id, 'amount'=>$signup_konkrete, 'type'=>'sign up', 'currency'=>'konkrete', 'project_site' => url()]);

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
