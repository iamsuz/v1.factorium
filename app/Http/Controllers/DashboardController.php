<?php

namespace App\Http\Controllers;

use App\Credit;
use App\Color;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Investment;
use App\InvestmentInvestor;
use App\InvestingJoint;
use App\Invite;
use App\Mailers\AppMailer;
use App\Note;
use App\Project;
use App\ProjectConfiguration;
use App\ProjectConfigurationPartial;
use App\User;
use App\Market;
use Carbon\Carbon;
use App\IdDocument;
use Chumper\Datatable\Datatable;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\SiteConfiguration;
use Session;
use Mailgun\Mailgun;
use App\Transaction;
use App\Position;
use App\ProjectProg;
use App\ReferralLink;
use App\ReferralRelationship;
use App\Helpers\SiteConfigurationHelper;
use Illuminate\Mail\TransportManager;
use App\ProjectInterest;
use App\InvestmentRequest;
use App\ProjectEOI;
use App\ProspectusDownload;
use App\ProjectSpvDetail;
use App\UserRegistration;
use App\ThirdPartyListing;
use App\InvestorProjectToken;
use App\SchedulerJob;
use App\Http\Controllers\KonkreteController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use SendGrid\Mail\Mail as SendgridMail;
use Illuminate\Database\Eloquent\SoftDeletes;


class DashboardController extends Controller
{

    protected $siteConfiguration;
    protected $konkrete;

    /**
     * constructor for DashboardController
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->siteConfiguration = SiteConfiguration::where('project_site', url())->first();
        $this->konkrete = new KonkreteController();
        $this->uri = env('KONKRETE_IP', 'http://localhost:5050');
        if(isset(SiteConfiguration::where('project_site', url())->first()->audk_default_project_id)){
            $this->audkID = SiteConfiguration::where('project_site', url())->first()->audk_default_project_id;
        }else{
            $this->audkID = env('AUDK_PROJECT_ID',27);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $color = Color::where('project_site',url())->first();
        $users = User::where('registration_site',url());
        $projects = Project::all();
        $projects = $projects->where('project_site',url());
        $notes = Note::all();
        // $total_goal = Investment::all()->where('project_site',url())->sum('goal_amount');
        // $pledged_investments = InvestmentInvestor::all()->where('project_site',url())->where('hide_investment', 0);
        $activeP = $projects->where('project_site',url())->where('active', true);
        $goal_amount = [];
        $amount = [];
        $funds_received = [];

        foreach ($activeP as $proj) {
            $goal_amount[] = $proj->investment->goal_amount;
            $investors = $proj->investors;

            $pledged_investments = InvestmentInvestor::all()->where('project_site',url())->where('project_id', $proj->id)->where('hide_investment', false);
            foreach($pledged_investments as $pledged_investment){
                $amount[] = $pledged_investment->amount;;
            }

            $funds_received_investments = InvestmentInvestor::all()->where('project_site',url())->where('project_id', $proj->id)->where('hide_investment', false)->where('money_received', true);
            foreach($funds_received_investments as $funds_received_investment){
                $funds_received[] = $funds_received_investment->amount;;
            }
            // foreach($investors as $investor){
            //     $amount[] = $investor->getOriginal('pivot_amount');
            // }
        }

        $total_goal = array_sum($goal_amount);
        $pledged_investments = array_sum($amount);
        $total_funds_received = array_sum($funds_received);

        return view('dashboard.index', compact('users', 'projects', 'pledged_investments', 'total_goal', 'notes','color', 'total_funds_received'));
    }

    public function users()
    {
        $color = Color::where('project_site',url())->first();
        $users = User::where('registration_site',url())->paginate(30);;
        // dd($users);
        return view('dashboard.users.index', compact('users','color'));
    }

    public function projects()
    {
        $color = Color::where('project_site',url())->first();
        $projects = Project::all();
        $projects = $projects->where('project_site',url());
        $pledged_investments = InvestmentInvestor::where('hide_investment', '0')->get();

        return view('dashboard.projects.index', compact('projects', 'pledged_investments','color'));
    }

    //Projects from other estatebaron subdomains
    public function thirdPartyListings()
    {
        $color = Color::where('project_site',url())->first();
        $all_projects = Project::where('active', 1)->whereNotIn('project_site', [url()])->get();

        return view('dashboard.third_party_projects.allProjects', compact('all_projects','color'));
    }

    //Projects from other estatebaron subdomains
    public function showThirdPartyProject(Request $request)
    {
        if ($request->ajax()) {
            $third_party_listing = ThirdPartyListing::all();
            $project_id = $request->project_id;
            $third_party_listing = $third_party_listing->where('list_on_site',url())->where('project_id', $project_id)->first();
            if(!$third_party_listing)
            {
                $third_party_listing = new ThirdPartyListing;
                $third_party_listing->project_id = $project_id;
                $third_party_listing->list_on_site = url();
                $third_party_listing->save();
                $third_party_listing = ThirdPartyListing::all();
                $third_party_listing = $third_party_listing->where('list_on_site',url())->first();
            }
            if($request->checkValue == "1") {
                $status = $third_party_listing->update(['active'=> 1, 'updated_at'=>Carbon::now()]);
            }
            else {
                $status = $third_party_listing->update(['active'=> 0, 'updated_at'=>Carbon::now()]);
            }
            return 1;
        }
    }

    public function test()
    {
        $color = Color::where('project_site',url())->first();
        return view('dashboard.users.test',compact('color'));
    }

    public function getDashboardUsers()
    {
        $datatable = new Datatable();
        return $datatable->collection(User::all())
        ->showColumns('id')
        ->addColumn('Details',function($model){
            return $model;
        })
        ->showColumns('phone_number','email')
        ->searchColumns('first_name')
        ->orderColumns('id','first_name')
        ->make();
    }

    public function getDashboardProjects()
    {
        $datatable = new Datatable();
        return $datatable->collection(Project::all())
        ->showColumns('id', 'title', 'active', 'description')
        ->searchColumns('title', 'description')
        ->orderColumns('id','title', 'active')
        ->make();
    }

    public function showUser($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.show', compact('user','color'));
    }

    public function usersInvestments($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        $investments = InvestmentInvestor::where('user_id', $user->id)
        ->where('project_site', url())->get();
        return view('dashboard.users.investments', compact('user','color', 'investments'));
    }

//Disabled in routes as well due to no usage
/*    public function showProject($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        return view('dashboard.projects.show', compact('project', 'investments','color'));
    }*/

    public function projectInvestors($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        $shareInvestments = InvestmentInvestor::where('project_id', $project_id)
        ->where('accepted', 1)
        ->orderBy('share_certificate_issued_at','ASC')
        ->get();
        $transactions = Transaction::where('project_id', $project_id)->get();
        // dd($transactions);
        $positions = Position::where('project_id', $project_id)->orderBy('effective_date', 'DESC')->get()->groupby('user_id');
        $projectsInterests = ProjectInterest::where('project_id', $project_id)->orderBy('created_at', 'DESC')->get();
        $projectsEois = ProjectEOI::where('project_id', $project_id)->orderBy('created_at', 'DESC')->get();
        $investorTokens = InvestorProjectToken::with(['user', 'project', 'scheduler_job'])->where('project_id', $project_id)->get();
        $investorTokensJobDetails = SchedulerJob::where('type', 'investor_project_tokens')->orderBy('created_at', 'desc')->first();
        // dd($positions);
        // dd($shareInvestments->last()->investingJoint);
        $balanceAudk = false;
        if($project->is_wallet_tokenized && $project->use_tokens){
            $client = new \GuzzleHttp\Client();
            $requestAudk = $client->request('GET',$this->uri.'/getProjectBalance/audk',[
                'query'=>['project_contract_id'=>$this->audkID,'project_id'=>$project->id]
            ]);
            $responseAudk = $requestAudk->getBody()->getContents();
            $balanceAudk = json_decode($responseAudk);
        }
        return view('dashboard.projects.investors', compact('project', 'investments','color', 'shareInvestments', 'transactions', 'positions', 'projectsInterests', 'projectsEois', 'balanceAudk', 'investorTokens', 'investorTokensJobDetails'));
    }

    public function editProject($project_id)
    {
        $color = Color::where('project_site',url())->first();
        $project = Project::findOrFail($project_id);
        $siteConfig = SiteConfiguration::where('project_site', url())->first();
        if(isset($siteConfig->audk_default_project_id)){
            $projectPayToken = Project::findOrFail($siteConfig->audk_default_project_id);
        }else{
            $projectPayToken = false;
        }
        if($project->project_site != url()){
            return redirect()->route('dashboard.projects')->withMessage('<p class="alert alert-warning text-center">Access Denied</p>');
        }
        $investments = InvestmentInvestor::where('project_id', $project_id)->get();
        if($project->is_coming_soon || $project->eoi_button == '1' || $project->is_funding_closed == '1'){
            $project->active = 1;
            $project->save();
        }
        if($project->eoi_button == '0' && $project->is_coming_soon == '0' && !$project->projectspvdetail) {
            $project->active = 0;
            $project->save();
        }

        $contract = array();
        if($project->contract_address) {
            $res = $this->konkrete->getContractDetails($project_id);
            $contractRes = json_decode($res->getContent());
            $contract = $contractRes->data;
        }
        if($project->contract_address && $project->is_wallet_tokenized) {
            $client = new \GuzzleHttp\Client();
            $request = $client->request('GET',$this->uri.'/getProjectBalance',[
                'query'=>['project_contract_id'=>$project->id,'project_id'=>$project->id]
            ]);
            $response = $request->getBody()->getContents();
            $balance = json_decode($response);
        }

        return view('dashboard.projects.edit', compact('project', 'investments','color', 'contract','balance','projectPayToken'));
    }

    public function activateUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $status = $user->update(['active'=> 1, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function deactivateUser($user_id)
    {
        $user = User::findOrFail($user_id);
        $status = $user->update(['active'=> 0, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }
    public function idDocVerification($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.idDocVerification',compact('user','color'));
    }
    public function idDocVerify(Request $request,AppMailer $mailer, $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->idDoc->update(['verified'=>$request->status]);
        $user->idDoc()->get()->last()->update(['verified'=>$request->status, 'id_comment'=>$request->fixing_message, 'joint_id_comment'=>$request->fixing_message_for_id]);
        $idimages = $user->idDoc()->get()->last();
        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->user_sign_up_konkrete) {
            $kyc_approval_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->kyc_approval_konkrete;
        }
        else {
            $kyc_approval_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->kyc_approval_konkrete;
        };

        if($request->status == '1') {
            $invitee = Invite::whereEmail($user->email)->first();
            if($invitee) {
                Credit::create(['user_id'=>$invitee->user_id, 'invite_id'=>$invitee->id, 'amount'=>200, 'type'=>'KYC Confirmed by Admin', 'currency'=>'konkrete', 'project_site' => url()]);
            }
            $refRel = ReferralRelationship::where('user_id',$user->id)->get()->first();
            if($refRel){
                $refLink = ReferralLink::find($refRel->referral_link_id);
                $refUser = User::find($refLink->user_id);
                $credit = Credit::create(['user_id'=>$refUser->id, 'amount'=>200, 'type'=>'KYC Verfied of '.$user->first_name.' '.$user->last_name, 'currency'=>'konkrete', 'project_site' => url()]);
            }
            $credit = Credit::create(['user_id'=>$user->id, 'amount'=>$kyc_approval_konkrete, 'type'=>'KYC Verification successful', 'currency'=>'konkrete', 'project_site' => url()]);
            $message = '<p class="alert alert-success text-center">User has been verified successfully and a notification has been sent.</p>';
        } else {
            $message = '<p class="alert alert-warning text-center">User has to try again.</p>';
        }
        $mailer->sendVerificationNotificationToUser($user, $request->status, $idimages);
        return redirect()->back()->withMessage($message);
    }
    public function verification($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.verification', compact('user','color'));
    }

    public function verifyId(Request $request, AppMailer $mailer, $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->update(['verify_id'=>$request->status]);
        $user->idImage()->get()->last()->update(['verify_id'=>$request->status, 'fixing_message'=>$request->fixing_message, 'fixing_message_for_id'=>$request->fixing_message_for_id]);
        $idimages = $user->idImage()->get()->last();
        if($request->status == '2') {
            $invitee = Invite::whereEmail($user->email)->first();
            if($invitee) {
                Credit::create(['user_id'=>$invitee->user_id, 'invite_id'=>$invitee->id, 'amount'=>50, 'type'=>'User Confirmed by Admin', 'project_site' => url()]);
            }
            $message = '<p class="alert alert-success text-center">User has been verified successfully and a notification has been sent.</p>';
        } else {
            $message = '<p class="alert alert-warning text-center">User has to try again.</p>';
        }
        $mailer->sendVerificationNotificationToUser($user, $request->status, $idimages);
        return redirect()->back()->withMessage($message);
    }

    public function privateProject($project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> 2, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function toggleStatus(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> $request->active, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function updateInvestment(Request $request, $investment_id)
    {
        $this->validate($request, [
            'investor' => 'required',
            'amount' => 'required|numeric',
        ]);

        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->amount = $request->amount;
        $investment->save();

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully updated.</p>');

    }

    public function acceptInvestment(Request $request, AppMailer $mailer, $investment_id)
    {
        $this->validate($request, [
            'investor' => 'required',
        ]);
        $investment = InvestmentInvestor::findOrFail($investment_id);
        if($investment){
            if($investment->project->is_wallet_tokenized)
            {
                $client = new \GuzzleHttp\Client();
                $requestInvest = $client->request('GET',$this->uri.'/investment/transaction',[
                    'query' => ['user_id' => $investment->user_id,'project_id'=>$investment->project_id,'securityTokens'=>$investment->amount,'project_address'=>$investment->project->wallet_address]
                ]);
                $responseInvest = $requestInvest->getBody()->getContents();
                $resultInvest = json_decode($responseInvest);
            }
            $investmentShares = InvestmentInvestor::where('project_id', $investment->project_id)
            ->where('accepted', 1)
            ->orderBy('share_certificate_issued_at','DESC')->get()
            ->first();
            $shareInit = 0;
            if($investmentShares){
                if($investmentShares->share_number){
                    $shareNumber = explode('-', $investmentShares->share_number);
                    $shareInit = $shareNumber[1];
                }
            }
            $shareStart = $shareInit+1;
            $shareEnd = $shareInit+$investment->amount;
            $shareCount = (string)($shareStart)."-".(string)($shareEnd);
            //Update current investment and with the share certificate details
            $investment->accepted = 1;
            $investment->money_received = 1;
            $investment->share_certificate_issued_at = Carbon::now();
            $investment->share_number = $shareCount;
            if(isset($resultInvest)){
                $investment->transaction_hash = $resultInvest->hash;
            }
            if($investment->project->share_vs_unit){
                $investment->share_certificate_path = "/app/invoices/Share-Certificate-".$investment->id.".pdf";
            }else{
                $investment->share_certificate_path = "/app/invoices/Share-Certificate-".$investment->id.".pdf";
            }
            $investment->save();
            // dd($investment);
            // Save details to transaction table
            $noOfShares = $shareEnd-$shareInit;
            $transactionRate = $investment->amount/$noOfShares;
            Transaction::create([
                'user_id' => $investment->user_id,
                'project_id' => $investment->project_id,
                'investment_investor_id' => $investment->id,
                'transaction_type' => 'BUY',
                'transaction_date' => Carbon::now(),
                'amount' => round($investment->amount,2),
                'rate' => round($transactionRate,2),
                'number_of_shares' => $noOfShares,
            ]);

            $investing = InvestingJoint::where('investment_investor_id', $investment->id)->get()->last();
            if($investment->accepted) {

                 // $pdf = PDF::loadView('pdf.invoice', ['investment' => $investment, 'shareInit' => $shareInit, 'investing' => $investing, 'shareStart' => $shareStart, 'shareEnd' => $shareEnd]);
                 // $pdf->setPaper('a4', 'landscape');
                 if($investment->project->share_vs_unit) {
                     // $pdf->save(storage_path().'/app/invoices/Share-Certificate-'.$investment->id.'.pdf');
                     $formLink = url().'/user/view/'.base64_encode($investment->id).'/share';
                 }else {
                     // $pdf->save(storage_path().'/app/invoices/Unit-Certificate-'.$investment->id.'.pdf');
                     $formLink = url().'/user/view/'.base64_encode($investment->id).'/unit';
                 }

                 $mailer->sendInvoiceToUser($investment,$formLink);
                 $mailer->sendInvoiceToAdmin($investment,$formLink);
            }
            if(isset($investment->pay_investment_id)){
                $linkedInvestment = InvestmentInvestor::findOrFail($investment->pay_investment_id);
                if($linkedInvestment){
                    if($linkedInvestment->project->is_wallet_tokenized)
                    {
                        $client = new \GuzzleHttp\Client();
                        $requestLinked = $client->request('POST',$this->uri.'/investment/transaction/repurchase',[
                            'query' => ['user_id' => $linkedInvestment->user_id,'project_id'=>$this->audkID,'securityTokens'=>$investment->amount,'project_address'=>$linkedInvestment->project->wallet_address]
                        ]);
                        $responseLinked = $requestLinked->getBody()->getContents();
                        $result = json_decode($responseLinked);
                    }
                    $investmentShares = InvestmentInvestor::where('project_id', $linkedInvestment->project_id)
                    ->where('accepted', 1)
                    ->orderBy('share_certificate_issued_at','DESC')->get()
                    ->first();
                    //Update current investment and with the share certificate details
                    $linkedInvestment->money_received = 1;
                    $linkedInvestment->save();

                    $investing = InvestingJoint::where('investment_investor_id', $linkedInvestment->id)->get()->last();
                }
            }
            return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully updated.</p>');
        }
    }

    public function activateProject($project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> 1, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    public function deactivateProject($project_id)
    {
        $project = Project::findOrFail($project_id);
        $status = $project->update(['active'=> 0, 'activated_on'=>Carbon::now()]);
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($user_id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::findOrFail($user_id);
        return view('dashboard.users.edit', compact('user','color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function siteConfigurations()
    {
        $color = Color::where('project_site',url())->first();
        $siteconfiguration = SiteConfiguration::where('project_site',url())->first();
        $projects = Project::where('active',1)->where('is_wallet_tokenized',1)->where('use_tokens',0)->get();
        $mail_setting = $siteconfiguration->mailSetting;
        $siteConfigurationHelper = SiteConfigurationHelper::getConfigurationAttr();
        return view('dashboard.configuration.siteConfiguration',compact('color','siteconfiguration','mail_setting', 'siteConfigurationHelper','projects'));
    }

    public function investmentMoneyReceived(Request $request, AppMailer $mailer, $investment_id)
    {
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->money_received = 1;
        $investment->save();

        if($investment->money_received) {
            $mailer->sendMoneyReceivedConfirmationToUser($investment);
        }

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Successfully updated.</p>');
    }

    public function hideInvestment(Request $request)
    {
        if ($request->ajax()) {
            $investment = InvestmentInvestor::findOrFail($request->investment_id);
            $investment->hide_investment = 1;
            $investment->save();
            return 1;
        }
    }

    public function hideApplicationFillupRequest(Request $request)
    {
        if ($request->ajax()) {
            $application_request = InvestmentRequest::findOrFail($request->application_request_id);
            $application_request->delete();
            return 1;
        }
    }

    public function investmentReminder(AppMailer $mailer, $investment_id){
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $mailer->sendInvestmentReminderToUser($investment);
        Session::flash('action', $investment->id);
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Reminder sent</p>');
    }

    public function investmentConfirmation(Request $request, AppMailer $mailer, $investment_id){
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->investment_confirmation = $request->investment_confirmation;
        $investment->save();
        $mailer->sendInvestmentConfirmationToUser($investment);
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Investment Successfully Confirmed</p>');
    }

    public function createBroadcastMailForm(){
        $color = Color::where('project_site',url())->first();
        $siteUsers = User::where('registration_site', url())->get();
        $siteconfiguration = SiteConfiguration::where('project_site',url())->first();
        return view('dashboard.broadcast.broadcastmail',compact('color','siteconfiguration', 'siteUsers'));
    }

    public function sendBroadcastMail(Request $request)
    {
        $this->validate($request, [
            'mail_subject' => 'required',
        ]);

        $subject = $request->mail_subject;
        $content = $request->mail_content;
        $emailStr = $request->email_string;

        $sendgridApiKey = \Config::get('services.sendgrid_key');
        $siteConfiguration = SiteConfiguration::where('project_site', url())->first();
        $mailSettings = $siteConfiguration->mailSetting()->first();
        if($siteConfiguration)
            $sendgridApiKey = $siteConfiguration->sendgrid_api_key ? $siteConfiguration->sendgrid_api_key : $sendgridApiKey;
        $setupEmail = isset($mailSettings->from) ? $mailSettings->from : (\Config::get('mail.from.address'));
        $setupEmailName = $siteConfiguration->title_text ? $siteConfiguration->title_text : (\Config::get('mail.from.name'));

        if($setupEmail == "info@estatebaron.com") {
            Session::flash('message', '<div class="alert alert-danger text-center">Please setup your email configurations first. <br>You can do that from <b><a href="'.route('dashboard.configurations').'">Configurations tab</a> > Mailer Email</b>.</div>');
            return redirect()->back();
        }

        $email = new SendgridMail();
        $email->setFrom($setupEmail, $setupEmailName);
        $email->setSubject($subject);
        $email->addTo($setupEmail);
        foreach (explode(',', $emailStr) as $userEmailId) {
            $email->addPersonalization(['to' => [['email' => $userEmailId]]]);
        }

        $email->addContent(
            "text/html", $content
        );

        $sendgrid = new \SendGrid($sendgridApiKey);
        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {
            throw new Exception("Error Processing Request", 1);
        }

        Session::flash('message', '<div class="row text-center" style="padding: 12px;border-radius: 8px;background-color: #EEFBF3;">Emails Queued Successfully</div>');

        return redirect()->back();
    }

    public function investmentCancel($investment_id, AppMailer $mailer)
    {
        $investment = InvestmentInvestor::findOrFail($investment_id);
        $investment->is_cancelled = 1;
        $investment->save();

        $shareInit = 0;
        if($investment->share_number){
            $shareNumber = explode('-', $investment->share_number);
            $shareInit = $shareNumber[0]-1;
        }
        $shareStart = $shareInit+1;
        $shareEnd = $shareInit+(int)$investment->amount;
        $shareCount = (string)($shareStart)."-".(string)($shareEnd);

        // Save details to transaction table
        $noOfShares = $shareEnd-$shareInit;
        if($noOfShares == 0){
            $transactionRate = $investment->amount/1;
        }
        else{
            $transactionRate = $investment->amount/$noOfShares;
        }
        // dd($transactionRate);
        Transaction::create([
            'user_id' => $investment->user_id,
            'project_id' => $investment->project_id,
            'investment_investor_id' => $investment->id,
            'transaction_type' => 'CANCELLED',
            'transaction_date' => Carbon::now(),
            'amount' => round($investment->amount,2),
            'rate' => round($transactionRate,2),
            'number_of_shares' => $noOfShares,
        ]);

        $investing = InvestingJoint::where('investment_investor_id', $investment->id)->get()->last();

        $mailer->sendInvestmentCancellationConfirmationToUser($investment, $shareInit, $investing, $shareStart, $shareEnd);

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Investment Successfully Cancelled</p>');
    }

    public function declareDividend(Request $request, AppMailer $mailer, $projectId)
    {
        if(!$request->start_date || !$request->end_date){
            return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Provide valid start date and end date</p>');
        }
        $investorList = $request->investors_list;
        $dividendPercent = $request->dividend_percent;
        $strStartDate = (string)$request->start_date;
        $startDate = date_create_from_format('d/m/Y', (string)$request->start_date);
        $strEndDate = (string)$request->end_date;
        $endDate = date_create_from_format('d/m/Y', (string)$request->end_date);
        $dateDiff = date_diff($startDate, $endDate);
        $dateDiff = (int)$dateDiff->format("%R%a") + 1;
        $project = Project::findOrFail($projectId);

        if($investorList != ''){
            if($dateDiff >=0){
                $investors = explode(',', $investorList);
                $investments = InvestmentInvestor::findMany($investors);

                // Add the records to project progress table
                ProjectProg::create([
                    'project_id' => $projectId,
                    'updated_date' => Carbon::now(),
                    'progress_description' => 'Dividend Declaration',
                    'progress_details' => 'A Dividend of '.$dividendPercent.'% annualized for the duration between '.date('m-d-Y', strtotime($request->start_date)).' and '.date('m-d-Y', strtotime($request->end_date)).' has been declared.'
                ]);

                // send dividend email to admins
                $csvPath = $this->exportDividendCSV($investments, $dividendPercent, $dateDiff, $project);
                $mailer->sendDividendDistributionNotificationToAdmin($investments, $dividendPercent, $dateDiff, $csvPath, $project);

                // send dividend emails to investors
                $failedEmails = [];
                $subject = 'Dividend declared for '.$project->title;
                foreach ($investments as $investment) {
                    // Save details to transaction table
                    $dividendAmount = round($investment->amount * ((int)$dividendPercent/(365*100)) * $dateDiff, 2);
                    $shareNumber = explode('-', $investment->share_number);
                    $noOfShares = $shareNumber[1]-$shareNumber[0]+1;
                    Transaction::create([
                        'user_id' => $investment->user_id,
                        'project_id' => $investment->project_id,
                        'investment_investor_id' => $investment->id,
                        'transaction_type' => 'DIVIDEND',
                        'transaction_date' => Carbon::now(),
                        'amount' => $dividendAmount,
                        'rate' => $dividendPercent,
                        'number_of_shares' => $noOfShares,
                    ]);

                    $content = \View::make('emails.userDividendDistributioNotify', array('investment' => $investment, 'dividendPercent' => $dividendPercent, 'startDate' => $strStartDate, 'endDate' => $strEndDate, 'project' => $project));
                    $result = $this->queueEmailsUsingMailgun($investment->user->email, $subject, $content->render());
                    if($result->http_response_code != 200){
                        array_push($failedEmails, $investment->user->email);
                    }
                }
                if(empty($failedEmails)){
                    return redirect()->back()->withMessage('<p class="alert alert-success text-center">Dividend distribution have been mailed to Investors and admins</p>');
                }
                else{
                    $emails = '';
                    foreach ($failedEmails as $email) {
                        $emails = $emails.", $email";
                    }
                    return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Dividend distribution email sending failed for investors - '.$emails.'.</p>');
                }
            }
            else {
                return redirect()->back()->withMessage('<p class="alert alert-danger text-center">End date must be greater than start date.</p>');
            }
        }
    }

    public function declareFixedDividend(Request $request, AppMailer $mailer, $projectId)
    {
        $investorList = $request->investors_list;
        $dividendPercent = $request->fixed_dividend_percent;
        $project = Project::findOrFail($projectId);

        if($investorList != ''){
            $investors = explode(',', $investorList);
            $investments = InvestmentInvestor::findMany($investors);
            if($project->use_tokens){
                $totalBalance = $investments->sum('amount');
                $client = new \GuzzleHttp\Client();
                $requestAudk = $client->request('GET',$this->uri.'/getProjectBalance/audk',[
                    'query'=>['project_contract_id'=>$this->audkID,'project_id'=>$project->id]
                ]);
                $responseAudk = $requestAudk->getBody()->getContents();
                $balanceAudk = json_decode($responseAudk);
                if($balanceAudk->balance < $totalBalance){
                    return redirect()->back()->withMessage('Your project doesnt have enough AUDK tokens to make this transaction');
                }
            }
            // Add the records to project progress table
            ProjectProg::create([
                'project_id' => $projectId,
                'updated_date' => Carbon::now(),
                'progress_description' => 'Fixed Dividend Declaration',
                'progress_details' => 'A Fixed Dividend of '.$dividendPercent.'% has been declared.'
            ]);

            // send dividend email to admins
            $csvPath = $this->exportFixedDividendCSV($investments, $dividendPercent, $project);
            $mailer->sendFixedDividendDistributionNotificationToAdmin($investments, $dividendPercent, $csvPath, $project);

            // send dividend emails to investors
            $failedEmails = [];
            $subject = 'Partial repurchase declared for '.$project->title;
            foreach ($investments as $investment) {
                // Save details to transaction table
                $dividendAmount = round($investment->total_projected_costs * ((int)$dividendPercent/100));
                $shareNumber = explode('-', $investment->share_number);
                $noOfShares = $shareNumber[1]-$shareNumber[0]+1;
                if($project->use_tokens){
                    if($balanceAudk->balance >= $totalBalance){
                        $dividendAUDK = $client->request('GET',$this->uri.'/investment/transaction',[
                            'query'=>['user_id'=> $investment->user_id,'project_id'=>$this->audkID,'securityTokens'=>(int)$dividendAmount,'project_address'=>$investment->project->wallet_address]
                        ]);
                        $responseDividendAudk = $dividendAUDK->getBody()->getContents();
                        $balance = json_decode($responseDividendAudk);
                    }
                }
                Transaction::create([
                    'user_id' => $investment->user_id,
                    'project_id' => $investment->project_id,
                    'investment_investor_id' => $investment->id,
                    'transaction_type' => 'FIXED DIVIDEND',
                    'transaction_date' => Carbon::now(),
                    'amount' => $dividendAmount,
                    'rate' => $dividendPercent,
                    'number_of_shares' => $noOfShares,
                ]);

                $content = \View::make('emails.userFixedDividendDistributioNotify', array('investment' => $investment, 'dividendPercent' => $dividendPercent, 'project' => $project));
                $result = $this->queueEmailsUsingMailgun($investment->user->email, $subject, $content->render());
                if($result->http_response_code != 200){
                    array_push($failedEmails, $investment->user->email);
                }
            }
            if(empty($failedEmails)){
                return redirect()->back()->withMessage('<p class="alert alert-success text-center">Fixed Dividend distribution have been mailed to Investors and admins</p>');
            }
            else{
                $emails = '';
                foreach ($failedEmails as $email) {
                    $emails = $emails.", $email";
                }
                return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Fixed Dividend distribution email sending failed for investors - '.$emails.'.</p>');
            }
        }
    }

    public function declareRepurchase(Request $request, AppMailer $mailer, $projectId){
        $investorList = $request->investors_list;
        $repurchaseRate = $request->repurchase_rate;
        $project = Project::findOrFail($projectId);

        if($investorList != ''){
            $investors = explode(',', $investorList);
            $investments = InvestmentInvestor::findMany($investors);
            // Add the records to project progress table
            if($project->share_vs_unit) {
                ProjectProg::create([
                    'project_id' => $projectId,
                    'updated_date' => Carbon::now(),
                    'progress_description' => 'Repurchase Declaration',
                    'progress_details' => 'Shares Repurchased by company at $'.$repurchaseRate.' per share.'
                ]);
            }else {
                ProjectProg::create([
                    'project_id' => $projectId,
                    'updated_date' => Carbon::now(),
                    'progress_description' => 'Repurchase Declaration',
                    'progress_details' => 'Units Repurchased by company at $'.$repurchaseRate.' per unit.'
                ]);
            }

            // send dividend email to admins
            $csvPath = $this->exportRepurchaseCSV($investments, $repurchaseRate, $project);
            // $mailer->sendRepurchaseNotificationToAdmin($investments, $repurchaseRate, $csvPath, $project);

            // send dividend emails to investors
            $failedEmails = [];
            if($project->share_vs_unit) {
                $subject = 'Shares for '.$project->title;
            }else {
                $subject = 'Units for '.$project->title;
            }
            foreach ($investments as $investment) {
                InvestmentInvestor::where('id', $investment->id)->update([
                    'is_cancelled' => 1,
                    'is_repurchased' => 1
                ]);

                // Save details to transaction table
                $repurchaseAmount = round(($investment->amount * $repurchaseRate), 2);
                $shareNumber = explode('-', $investment->share_number);
                $noOfShares = $shareNumber[1]-$shareNumber[0]+1;
                if($project->is_wallet_tokenized){
                    if($project->use_tokens){
                        $client = new \GuzzleHttp\Client();
                        $requestAudk = $client->request('GET',$this->uri.'/getProjectBalance/audk',[
                            'query'=>['project_contract_id'=>$this->audkID,'project_id'=>$project->id]
                        ]);
                        $responseAudk = $requestAudk->getBody()->getContents();
                        $balanceAudk = json_decode($responseAudk);
                        if($balanceAudk->balance < $repurchaseAmount){
                            return redirect()->back()->withMessage('Your Project doesnt have enough AUDK tokens in Wallet. Buy AUDK tokens before Repurchasing transactions <br> <a href="https://ether.estatebaron.com/projects/58">Here</a> you can buy it.');
                        }
                        $client = new \GuzzleHttp\Client();
                        $requestRepurchase = $client->request('POST',$this->uri.'/investment/transaction/repurchase',[
                            'query' => ['user_id' => $investment->user_id,'project_id'=>$projectId,'securityTokens'=>$repurchaseAmount,'project_address'=>$investment->project->wallet_address]
                        ]);
                        $responseRepurchase = $requestRepurchase->getBody()->getContents();
                        $result = json_decode($responseRepurchase);
                        $requestRepurchaseAudk = $client->request('GET',$this->uri.'/investment/transaction',[
                            'query'=>['user_id'=> $investment->user_id,'project_id'=>$this->audkID,'securityTokens'=>$repurchaseAmount,'project_address'=>$investment->project->wallet_address]
                        ]);
                        $responseRepurchaseAudk = $requestRepurchaseAudk->getBody()->getContents();
                        $balance = json_decode($responseRepurchaseAudk);
                    }else{
                        $client = new \GuzzleHttp\Client();
                        $requestRepurchase = $client->request('POST',$this->uri.'/investment/transaction/repurchase',[
                            'query' => ['user_id' => $investment->user_id,'project_id'=>$projectId,'securityTokens'=>$repurchaseAmount,'project_address'=>$investment->project->wallet_address]
                        ]);
                        $responseRepurchase = $requestRepurchase->getBody()->getContents();
                        $result = json_decode($responseRepurchase);
                    }
                }

                Transaction::create([
                    'user_id' => $investment->user_id,
                    'project_id' => $investment->project_id,
                    'investment_investor_id' => $investment->id,
                    'transaction_type' => 'REPURCHASE',
                    'transaction_date' => Carbon::now(),
                    'amount' => $repurchaseAmount,
                    'rate' => $repurchaseRate,
                    'number_of_shares' => $noOfShares,
                ]);

                $shareNumber = explode('-', $investment->share_number);
                $content = \View::make('emails.userRepurchaseNotify', array('investment' => $investment, 'repurchaseRate' => $repurchaseRate, 'project' => $project, 'shareNumber' => $shareNumber));
                $result = $this->queueEmailsUsingMailgun($investment->user->email, $subject, $content->render());
                if($result->http_response_code != 200){
                    array_push($failedEmails, $investment->user->email);
                }
            }
            if(empty($failedEmails)){
                return redirect()->back()->withMessage('<p class="alert alert-success text-center">Repurchase distribution have been mailed to Investors and admins</p>');
            }
            else{
                $emails = '';
                foreach ($failedEmails as $email) {
                    $emails = $emails.", $email";
                }
                return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Repurchase distribution email sending failed for investors - '.$emails.'.</p>');
            }
        }
    }

    public function exportDividendCSV($investments, $dividendPercent, $dateDiff, $project)
    {
        $csvPath = storage_path().'/app/dividend/dividend_distribution_'.time().'.csv';

        // create a file pointer connected to the output stream
        $file = fopen($csvPath, 'w');

        // Add column names to csv
        if($project->share_vs_unit) {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Share amount", "Number of days", "Rate", "Investor Dividend amount"));
        }else {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Unit amount", "Number of days", "Rate", "Investor Dividend amount"));
        }

        // data to add to the csv file
        foreach ($investments as $investment) {
            fputcsv($file, array(
                $investment->user->first_name.' '.$investment->user->last_name,
                $investment->investingJoint ? $investment->investingJoint->account_name : $investment->user->account_name,
                $investment->investingJoint ? $investment->investingJoint->bank_name : $investment->user->bank_name,
                $investment->investingJoint ? $investment->investingJoint->bsb : $investment->user->bsb,
                $investment->investingJoint ? $investment->investingJoint->account_number : $investment->user->account_number,
                $investment->amount,
                $dateDiff,
                $dividendPercent,
                round($investment->amount * ((int)$dividendPercent/(365*100)) * $dateDiff, 2)
            ));
        }

        // Close the file
        fclose($file);

        return $csvPath;
    }

    public function exportFixedDividendCSV($investments, $dividendPercent, $project)
    {
        $csvPath = storage_path().'/app/dividend/fixed_dividend_distribution_'.time().'.csv';

        // create a file pointer connected to the output stream
        $file = fopen($csvPath, 'w');

        // Add column names to csv
        if($project->share_vs_unit) {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Share amount", "Rate", "Investor Dividend amount"));
        }else {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Unit amount", "Rate", "Investor Dividend amount"));
        }

        // data to add to the csv file
        foreach ($investments as $investment) {
            fputcsv($file, array(
                $investment->user->first_name.' '.$investment->user->last_name,
                $investment->investingJoint ? $investment->investingJoint->account_name : $investment->user->account_name,
                $investment->investingJoint ? $investment->investingJoint->bank_name : $investment->user->bank_name,
                $investment->investingJoint ? $investment->investingJoint->bsb : $investment->user->bsb,
                $investment->investingJoint ? $investment->investingJoint->account_number : $investment->user->account_number,
                '$'.$project->investment->total_projected_costs,
                $dividendPercent,
                '$'.$project->investment->total_projected_costs * ((int)$dividendPercent/100)
            ));
        }

        // Close the file
        fclose($file);

        return $csvPath;
    }

    public function exportRepurchaseCSV($investments, $repurchaseRate, $project){
        $csvPath = storage_path().'/app/repurchase/repurchase_distribution_'.time().'.csv';

        // create a file pointer connected to the output stream
        $file = fopen($csvPath, 'w');

        // Add column names to csv
        if($project->share_vs_unit) {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Share amount", "Repurchase Rate", "Investor Repurchase amount"));
        }else {
            fputcsv($file, array("Investor Name", "Investor Bank account name", "Investor bank", "Investor BSB", "Investor Account", "Unit amount", "Repurchase Rate", "Investor Repurchase amount"));
        }

        // data to add to the csv file
        foreach ($investments as $investment) {
            fputcsv($file, array(
                $investment->user->first_name.' '.$investment->user->last_name,
                $investment->investingJoint ? $investment->investingJoint->account_name : $investment->user->account_name,
                $investment->investingJoint ? $investment->investingJoint->bank_name : $investment->user->bank_name,
                $investment->investingJoint ? $investment->investingJoint->bsb : $investment->user->bsb,
                $investment->investingJoint ? $investment->investingJoint->account_number : $investment->user->account_number,
                $project->investment->total_projected_costs,
                $repurchaseRate,
                round($project->investment->total_projected_costs * $repurchaseRate, 2)
            ));
        }

        // Close the file
        fclose($file);

        return $csvPath;
    }

    public function queueEmailsUsingMailgun($emailStr, $subject, $content, $attachments = [])
    {
        $this->overrideMailerConfig();
        if(filter_var(\Config::get('mail.sendmail'), FILTER_VALIDATE_EMAIL)){
            $fromMail = \Config::get('mail.sendmail');
        } else{
            $fromMail = 'info@estatebaron.com';
        }

        //Disable SSL Check
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        $adapter = new \Http\Adapter\Guzzle6\Client($client);

        # Instantiate the client.
        $mgClient = new Mailgun(env('MAILGUN_API_KEY'), $adapter);
        $domain = env('MAILGUN_DOMAIN');

        # Make the call to the client.
        $result = $mgClient->sendMessage($domain,
            array(
                'from'    => $fromMail,
                'to'      => $emailStr,
                // 'bcc'     => 'info@estatebaron.com',
                'subject' => $subject,
                'html'    => $content
            ),
            array(
                'attachment' => $attachments
            )
        );

        return $result;
    }

    public function investmentStatement($projectId)
    {
        $investmentRecords = InvestmentInvestor::where('project_id', $projectId)
        ->where(function ($query) { $query->where('is_cancelled', 0)->where('is_repurchased', 0); })
        ->get()->groupby('user_id');
        foreach ($investmentRecords as $userId => $investments) {
            $UserShares = 0;
            foreach ($investments as $key => $investment) {
                if($investment->accepted && $investment->share_number){
                    $shareNumber = explode('-', $investment->share_number);
                    $noOfShares = $shareNumber[1]-$shareNumber[0]+1;
                    $UserShares += $noOfShares;
                }
            }
            // dd($UserShares);
            Position::create([
                'user_id' => $userId,
                'project_id' => $projectId,
                'effective_date' => Carbon::now(),
                'number_of_shares' => $UserShares,
                'current_value' => $UserShares * 1
            ]);
        }
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Latest Investor Statement is successfully generated.<br>You can view it in Position records tab.</p>');
    }

    public function sendInvestmentStatement($projectId)
    {
        $positions = Position::where('project_id', $projectId)->orderBy('effective_date', 'DESC')->get()->groupby('user_id');
        $failedEmails = [];
        foreach ($positions as $userId => $value) {
            $position = $value->first();
            $transactions = Transaction::where('project_id', $projectId)->where('user_id', $userId)->orderBy('transaction_date', 'ASC')->get();
            $project = Project::where('id', $projectId)->first();

            // Create PDF of Investor Statement
            $pdfPath = storage_path().'/app/investorStatement/investor-statement-'.$userId.'-'.time().'.pdf';
            $pdf = PDF::loadView('pdf.investorStatement', ['project' => $project, 'position' => $position, 'transactions' => $transactions]);
            $pdf->setPaper('a4', 'portrait');
            $pdf->save($pdfPath);

            // Send Investor Statement mail to investors
            $projectName = $project->projectspvdetail ? $project->projectspvdetail->spv_name : $project->title;
            $subject = 'Investor statement for '.$position->user->first_name.' '.$position->user->last_name.' for '.$projectName;
            $content = \View::make('emails.investorStatement', array('project' => $project, 'position' => $position));
            $attachments = array($pdfPath);
            $result = $this->queueEmailsUsingMailgun($position->user->email, $subject, $content->render(), $attachments);
            if($result->http_response_code != 200){
                array_push($failedEmails, $position->user->email);
            }
        }
        if(empty($failedEmails)){
            return redirect()->back()->withMessage('<p class="alert alert-success text-center">Investor Statement have been successfully mailed to Investors</p>');
        }
        else{
            $emails = '';
            foreach ($failedEmails as $email) {
                $emails = $emails.", $email";
            }
            return redirect()->back()->withMessage('<p class="alert alert-danger text-center">Investor Statement email sending failed for investors - '.$emails.'.</p>');
        }
    }

    public function overrideMailerConfig()
    {
        $siteconfig = SiteConfigurationHelper::getConfigurationAttr();
        $config = $siteconfig->mailSetting()->first();
        if($config){
            // Config::set('mail.driver',$configs['driver']);
            \Config::set('mail.host',$config->host);
            \Config::set('mail.port',$config->port);
            \Config::set('mail.username',$config->username);
            \Config::set('mail.password',$config->password);
            \Config::set('mail.sendmail',$config->from);
            $app = \App::getInstance();
            $app['swift.transport'] = $app->share(function ($app) {
               return new TransportManager($app);
           });

            $mailer = new \Swift_Mailer($app['swift.transport']->driver());
            \Mail::setSwiftMailer($mailer);
        }
    }

    public function applicationForm($investment_id)
    {
        $investment = InvestmentInvestor::find($investment_id);
        // dd($investment);
        if($investment->application_path){
            $filename = $investment->application_path;
            $path = storage_path($filename);

            return \Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }
        else {
            $project = Project::find($investment->project_id);
            $user = User::findOrFail($investment->user_id);
            // dd($user);

            // Create PDF of Application form
            $pdfBasePath = '/app/application/application-'.$investment->id.'-'.time().'.pdf';
            $pdfPath = storage_path().$pdfBasePath;
            $pdf = PDF::loadView('pdf.application', ['project' => $project, 'investment' => $investment, 'user' => $user]);
            $pdf->setPaper('a4', 'portrait');
            $pdf->setWarnings(false);
            $saveResult = $pdf->save($pdfPath);
            $investment->application_path = $pdfBasePath;
            $investment->save();

            if($saveResult){
                return \Response::make(file_get_contents($pdfPath), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="'.$pdfBasePath.'"'
                ]);
            }
        }
    }

    /**
     * Show list of all Investment form filling requests which are pending
     */
    public function investmentRequests()
    {
        $investmentRequests = InvestmentRequest::where('is_link_expired', 0)
        ->whereRaw('investment_requests.project_id IN (select id from projects where project_site="'.url().'")')
        ->get();

        $color = Color::where('project_site',url())->first();
        return view('dashboard.requests.requests', compact('investmentRequests', 'color'));
    }

    /**
     * Returns the list of all the users downloaded prospectus
     */
    public function prospectusDownloads()
    {
        $prospectusDownloads = ProspectusDownload::where('project_site', url())
        ->orderBy('created_at','DESC')
        ->get();
        $color = Color::where('project_site',url())->first();
        return view('dashboard.prospectusDownloads', compact('prospectusDownloads', 'color'));
    }

    public function sendEoiLink(Request $request, AppMailer $mailer)
    {
        if ($request->ajax()) {
            $project = Project::find($request->project_id);
            $eoi = ProjectEOI::find($request->eoi_id);
            $mailer->sendEoiApplicationLinkToUser($project, $eoi);
            $eoi->update([
                'is_link_sent' => 1
            ]);
            return 1;
        }
    }

    public function uploadOfferDoc(Request $request)
    {
        $this->validate($request, [
            'offer_doc' => 'required|mimes:pdf',
            'eoi_id' => 'required'
        ]);
        $projectEoi = ProjectEOI::find($request->eoi_id);

        if (!file_exists(public_path().'/assets/documents/eoi/'.$projectEoi->id)) {
            File::makeDirectory(public_path().'/assets/documents/eoi/'.$projectEoi->id, 0775, true);
        }
        if($projectEoi->offer_doc_path){
            File::delete(public_path().$projectEoi->offer_doc_path);
        }
        $destinationPath = '/assets/documents/eoi/'.$projectEoi->id;
        $uniqueFileName = uniqid() . '-' . $request->file('offer_doc')->getClientOriginalName();
        $request->file('offer_doc')->move(public_path().$destinationPath, $uniqueFileName);

        $projectEoi->update([
            'offer_doc_path' => $destinationPath.'/'.$uniqueFileName,
            'offer_doc_name' => $uniqueFileName
        ]);
        if($projectEoi->offer_doc_path) {
            return response()->json([
                'status' => '1',
                'message' => 'File Uploaded Successfully. You can now send application link to the user',
                'eoi_id' => $projectEoi->id,
                'offer_doc_path' => $projectEoi->offer_doc_path,
                'offer_doc_name' => $projectEoi->offer_doc_name,
            ]);
        }
        else
        {
            return response()->json([
                'status' => '0',
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function kycRequests()
    {
        $color = Color::where('project_site',url())->first();
        $kycRequests = IdDocument::groupBy('user_id')->get()->where('registration_site',url());
        return view('dashboard.requests.kycRequest',compact('kycRequests','color'));
    }

    public function documents(Request $request,$id)
    {
        $color = Color::where('project_site',url())->first();
        $user = User::find($id);
        return view('dashboard.users.idDoc',compact('color','user'));
    }

    //Upload KYC documents for users by admin
    public function uploadDocuments(Request $request,AppMailer $mailer,$id)
    {
        $validation_rules = array(
            'joint_investor_id_doc'   => 'mimes:jpeg,jpg,png,pdf',
            'trust_or_company_docs'   => 'mimes:jpeg,jpg,png,pdf',
            'user_id_doc'   => 'mimes:jpeg,jpg,png,pdf'
        );
        $validator = Validator::make($request->all(), $validation_rules);
        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
        }
        $user = User::find($id);
        $check = IdDocument::where('user_id',$user->id)->first();
        // $user->idDoc()->get()->last()->update(['verified'=>$request->status, 'id_comment'=>$request->fixing_message, 'joint_id_comment'=>$request->fixing_message_for_id]);
        // $idimages = $user->idDoc()->get()->last();
        if($request->hasFile('joint_investor_id_doc'))
        {
            $destinationPath = 'assets/users/kyc/'.$user->id.'/joint/'.$request->joint_investor_first.'_'.$request->joint_investor_last.'/';
            $filename = $request->file('joint_investor_id_doc')->getClientOriginalName();
            $fileExtension = $request->file('joint_investor_id_doc')->getClientOriginalExtension();
            $request->file('joint_investor_id_doc')->move($destinationPath, $filename);
            if($check){
                $user_doc = $user->idDoc()->update(['joint_id_filename'=>$filename, 'joint_id_path'=>$destinationPath.$filename,'joint_id_extension'=>$fileExtension,'investing_as'=>$request->investing_as,'joint_first_name'=>$request->joint_investor_first,'joint_last_name'=>$request->joint_investor_last,'registration_site'=>url(), 'verified'=>1]);
            }else{
                $user_doc = IdDocument::create(['type'=>'JointDocument', 'joint_id_filename'=>$filename, 'joint_id_path'=>$destinationPath.$filename,'joint_id_extension'=>$fileExtension,'user_id'=>$user->id,'investing_as'=>$request->investing_as,'joint_first_name'=>$request->joint_investor_first,'joint_last_name'=>$request->joint_investor_last,'registration_site'=>url(), 'verified'=>1]);
                // $user->idDoc()->save($user_doc);
            }
        }
        $check = IdDocument::where('user_id',$user->id)->first();
        if($request->hasFile('trust_or_company_docs'))
        {
            $destinationPath = 'assets/users/kyc/'.$user->id.'/trust/'.$request->investing_company_name.'/';
            $filename = $request->file('trust_or_company_docs')->getClientOriginalName();
            $fileExtension = $request->file('trust_or_company_docs')->getClientOriginalExtension();
            $request->file('trust_or_company_docs')->move($destinationPath, $filename);
            if($check){
                $user_doc = $user->idDoc()->update(['filename'=>$filename, 'path'=>$destinationPath.$filename,'extension'=>$fileExtension,'investing_as'=>$request->investing_as,'trust_or_company'=>$request->investing_company_name,'registration_site'=>url(), 'verified'=>1]);
            }else{
                $user_doc = new IdDocument(['type'=>'TrustDoc', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'extension'=>$fileExtension,'user_id'=>$user->id,'extension'=>$fileExtension,'investing_as'=>$request->investing_as,'trust_or_company'=>$request->investing_company_name,'registration_site'=>url(), 'verified'=>1]);
                $user->idDoc()->save($user_doc);
            }

        }
        $check = IdDocument::where('user_id',$user->id)->first();
        if($request->hasFile('user_id_doc'))
        {
            $destinationPath = 'assets/users/kyc/'.$user->id.'/doc/';
            $filename = $request->file('user_id_doc')->getClientOriginalName();
            $fileExtension = $request->file('user_id_doc')->getClientOriginalExtension();
            $request->file('user_id_doc')->move($destinationPath, $filename);
            if($check){
                $user_doc = $user->idDoc()->update(['filename'=>$filename, 'path'=>$destinationPath.$filename,'user_id'=>$user->id,'extension'=>$fileExtension,'investing_as'=>$request->investing_as,'registration_site'=>url(), 'verified'=>1]);
            }else{
                $user_doc = new IdDocument(['type'=>'Document', 'filename'=>$filename, 'path'=>$destinationPath.$filename,'user_id'=>$user->id,'extension'=>$fileExtension,'investing_as'=>$request->investing_as,'registration_site'=>url(), 'verified'=>1]);
                $user->idDoc()->save($user_doc);
            }
        }

        if(\App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->kyc_approval_konkrete) {
            $kyc_approval_konkrete = \App\Helpers\SiteConfigurationHelper::getConfigurationAttr()->kyc_approval_konkrete;
        }
        else {
            $kyc_approval_konkrete = \App\Helpers\SiteConfigurationHelper::getEbConfigurationAttr()->kyc_approval_konkrete;
        };

        // $user_konkrete = Credit::where('user_id',$user->id)->first();
        if(!$check) {
            $credit = Credit::create(['user_id'=>$user->id, 'amount'=>$kyc_approval_konkrete, 'type'=>'KYC Verification successful','currency'=>'konkrete', 'project_site' => url()]);
        }
        $idimages = IdDocument::where('user_id',$user->id)->first();
        $mailer->sendVerificationNotificationToUser($user, '1', $idimages);

        return redirect()->back()->withMessage('<p class="alert alert-success">User documents uploaded successfully.</p>');
    }

    public function viewApplication(Request $request, $id)
    {
        $color = Color::where('project_site',url())->first();
        $investment = InvestmentInvestor::find($id);
        $projects_spv = ProjectSpvDetail::where('project_id', $investment->project_id)->first();
        return view('dashboard.application.edit',compact('color','investment', 'projects_spv'));
    }


    public function updateApplication(Request $request, $investment_id)
    {
        // dd($request);

        $investment = InvestmentInvestor::findOrFail($investment_id);
        // dd($investment->investingJoint);
        $user = $investment->user;

        $project = Project::findOrFail($investment->project_id);
        $min_amount_invest = $project->investment->minimum_accepted_amount;
        if((int)$request->amount_to_invest < (int)$min_amount_invest)
        {
            return redirect()->back()->withErrors(['The amount to invest must be at least '.$min_amount_invest]);
        }
        if((int)$request->amount_to_invest % 100 != 0)
        {
            return redirect()->back()->withErrors(['Please enter amount in increments of $100 only']);
        }
        $validation_rules = array(
            'amount_to_invest'   => 'required|numeric',
            'line_1' => 'required',
            'state' => 'required',
            'postal_code' => 'required'
        );
        $validator = Validator::make($request->all(), $validation_rules);

        // Return back to form with validation errors & session data as input
        if($validator->fails()) {
            return  redirect()->back()->withErrors($validator);
        }

        $investment_investor_id = $investment_id;
        $wholesale_investing = InvestmentInvestor::findOrFail($investment_investor_id);

        //Save wholesale project input fields
        if($request->wholesale_investing_as === 'Wholesale Investor (Net Asset $2,500,000 plus)'){
            $investment->wholesaleInvestment->update([
                'wholesale_investing_as' => $request->wholesale_investing_as,
                'accountant_name_and_firm' => $request->accountant_name_firm_txt,
                'accountant_professional_body_designation'=> $request->accountant_designation_txt,
                'accountant_email'=> $request->accountant_email_txt,
                'accountant_phone'=> $request->accountant_phone_txt,
            ]);
        }
        elseif($request->wholesale_investing_as === 'Sophisticated Investor'){
            $investment->wholesaleInvestment->update([
                'wholesale_investing_as' => $request->wholesale_investing_as,
                'experience_period' => $request->experience_period_txt,
                'equity_investment_experience_text'=> $request->equity_investment_experience_txt,
                'unlisted_investment_experience_text'=> $request->unlisted_investment_experience_txt,
                'understand_risk_text'=> $request->understand_risk_txt,
            ]);
        }
        else{
            $investment->wholesaleInvestment->update([
                'wholesale_investing_as' => $request->wholesale_investing_as
            ]);
        }
        $wholesale_investing->save();

        $result = $investment->update([
            'amount' => $request->amount_to_invest,
            'investing_as'=> $request->investing_as,
            'interested_to_buy'=> $request->interested_to_buy,
        ]);

        if($request->investing_as !== 'Individual Investor'){
            if($investment->investingJoint){
                $investing_joint = $investment->investingJoint;
                $result = $investing_joint->update([
                    'joint_investor_first_name' => $request->joint_investor_first,
                    'joint_investor_last_name' => $request->joint_investor_last,
                    'investing_company' => $request->investing_company_name,
                    'account_name' => $request->account_name,
                    'bsb' => $request->bsb,
                    'account_number' => $request->account_number,
                    'line_1' => $request->line_1,
                    'line_2' => $request->line_2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'country' => $request->country,
                    'country_code' => $request->country_code,
                    'tfn' => $request->tfn,
                ]);
            }
            else{
                $investing_joint = new InvestingJoint;
                $investing_joint->project_id = $project->id;
                $investing_joint->investment_investor_id = $investment->id;
                $investing_joint->joint_investor_first_name = $request->joint_investor_first;
                $investing_joint->joint_investor_last_name = $request->joint_investor_last;
                $investing_joint->investing_company = $request->investing_company_name;
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
        }

        $updateUserDetails = $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone,
            'tfn' => $request->tfn,
            'account_name' => $request->account_name,
            'bsb' => $request->bsb,
            'account_number' => $request->account_number,
            'line_1' => $request->line_1,
            'line_2' => $request->line_2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'country_code' => $request->country_code,
        ]);

        return redirect()->back()->withMessage('<p class="alert alert-success text-center">Application form updated successfully.</p>');

    }

    /**
     * \brief Show import CSV form
     * \details This shows a form to site admin to upload the CSV file containing users list.
     * \return View
     */
    public function showImportContacts()
    {
        $color = Color::where('project_site',url())->first();
        $siteconfiguration = SiteConfiguration::where('project_site',url())->first();
        return view('dashboard.importcontacts.importcontacts',compact('color','siteconfiguration'));
    }

    /**
     * \brief Import user contact CSV
     * \details - Allows site admin to upload the list of users in CSV file,
     *          - Save new users from CSV file to system
     *          - Send them registration bulk email using sendgrid
     *          - Allow users to register themselves using the email link
     * \return View
     */
    public function saveContactsFromCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contacts_csv_file' => 'required|mimes:csv,txt'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withMessage('<p class="alert alert-danger text-center">'.$validator->errors()->first().'</p>');
        }

        // START: Don't allow using this functionality unless admin sets his own mailer settings.
        $mailSettings = $this->siteConfiguration->mailSetting()->first();
        $setupEmail = isset($mailSettings->from) ? $mailSettings->from : (\Config::get('mail.from.address'));
        if($setupEmail == "info@estatebaron.com") {
            Session::flash('message', '<div class="alert alert-danger text-center">Please setup your email configurations first. <br>You can do that from <b><a href="'.route('dashboard.configurations').'">Configurations tab</a> > Mailer Email</b>.</div>');
            return redirect()->back();
        }
        // END.

        try {
            $csvTmpPath = $request->file('contacts_csv_file')->getRealPath();
            $alldata = array_map('str_getcsv', file($csvTmpPath));
            $csv_data = array_slice($alldata, 1);

            if(!empty($csv_data)) {
                $sendgridPersonalization = [];
                foreach ($csv_data as $key => $userRecord) {
                    if(
                        ($userRecord[0] != '') &&
                        ($userRecord[2] != '')
                    ) {
                        $toRegEmail = trim($userRecord[2]);
                        $user = User::where('email', $toRegEmail)->first();
                        $userReg = UserRegistration::where('email', $toRegEmail)->first();

                        if(!$user && !$userReg) {
                            $result = UserRegistration::create([
                                'email' => $toRegEmail,
                                'role' => \Config::get('constants.roles.INVESTOR'),
                                'registration_site' => url(),
                                'first_name' => trim($userRecord[0]),
                                'last_name' => trim($userRecord[1])
                            ]);
                            array_push(
                                $sendgridPersonalization,
                                [
                                    'to' => [[ 'email' => $result->email ]],
                                    'substitutions' => [
                                        '%first_name%' => $result->first_name,
                                        '%user_token%' => $result->token,
                                    ]
                                ]
                            );
                        }
                    }
                }

                // START: Sending bulk email using sendgrid
                $sitename = $this->siteConfiguration->website_name ? $this->siteConfiguration->website_name : 'Estate Baron';
                $resultBulkEmail =  $this->sendBulkEmail(
                    $sitename . ' invitation',
                    $sendgridPersonalization,
                    view('emails.sendgrid-api-specific.welcomeEmailForCSVImportedUser')->render()
                );

                if(!$resultBulkEmail['status']) {
                    return redirect()->back()->withMessage('<p class="alert alert-danger text-center">' . $resultBulkEmail->message . '</p>');
                }
                // END: Sending bulk email using sendgrid

            } else {
                return redirect()->back()->withMessage('<p class="alert alert-danger text-center">CSV file is empty</p>');
            }

        } catch(\Exception $e) {
            return redirect()->back()->withMessage('<p class="alert alert-danger text-center">' . $e->getMessage() . '</p>');
        }
        return redirect()->back()->withMessage('<p class="alert alert-success text-center">CSV file import done successfully.</p>');
    }

    /**
     * \brief Sendgrid bulk API
     * \details - Common function to send bulk email to multiple users.
     *          - Every email is personalized with respective user details.
     * \return Array
     */
    public function sendBulkEmail($subject, $sendgridPersonalization, $content = '')
    {
        $sendgridApiKey = \Config::get('services.sendgrid_key');
        $sendgridApiKey = $this->siteConfiguration->sendgrid_api_key ? $this->siteConfiguration->sendgrid_api_key : $sendgridApiKey;
        $mailSettings = $this->siteConfiguration->mailSetting()->first();
        $setupEmail = isset($mailSettings->from) ? $mailSettings->from : (\Config::get('mail.from.address'));
        $setupEmailName = $this->siteConfiguration->website_name ? $this->siteConfiguration->website_name : (\Config::get('mail.from.name'));

        $email = new SendgridMail();
        $email->setFrom($setupEmail, $setupEmailName);
        $email->setSubject($subject);
        $email->addTo($setupEmail);
        $email->addContent("text/html", $content);
        foreach ($sendgridPersonalization as $personalization) {
            $email->addPersonalization($personalization);
        }

        $sendgrid = new \SendGrid($sendgridApiKey);
        try {
            $response = $sendgrid->send($email);
        } catch (Exception $e) {
            return array(
                'status' => false,
                'message' => 'Failed to send bulk email. Error message: ' . $e->getMessage()
            );
        }

        return array('status' => true);
    }

    public function market(Request $request)
    {
        $color = Color::where('project_site',url())->first();
        $siteconfiguration = SiteConfiguration::where('project_site',url())->first();
        $askOrders = Market::orderBy('price','asc')->get();
        $bidOrders = Market::orderBy('price','desc')->get();
        // dd($askOrders);
        $projects = Project::all();
        return view('dashboard.market',compact('color','siteconfiguration','askOrders','projects','bidOrders'));
    }

    public function marketStore(Request $request, AppMailer $mailer)
    {
        $order = Market::find($request->market_id);
        $user = User::find($order->user_id);
        if($request->amount_of_shares != $order->amount_of_shares){
            $amount = $order->amount_of_shares - $request->amount_of_shares;
            $newOrder = Market::create([
                'user_id'=> $order->user_id,
                'project_id' => $order->project_id,
                'type' => $order->type,
                'price' => $order->price,
                'amount_of_shares' => $amount,
                'accepted' => 0,
                'is_money_received' => 0
            ]);
            $order->accepted = 1;
            $order->is_order_changed = 1;
            $order->original_shares = $order->amount_of_shares;
            $order->amount_of_shares = $request->amount_of_shares;
            $order->save();
            $mailer->sendMarketOrderAcceptToUser($user, $order);
            return redirect()->back()->withMessage('Order has been accepted with updated shares and New Order has been created for the same user');
        }else{
            $order->accepted = 1;
            $order->save();
            $mailer->sendMarketOrderAcceptToUser($user, $order);
            return redirect()->back()->withMessage('Order has been Accepted!');
        }
    }

    public function marketMoneyReceived(Request $request)
    {
        $order = Market::find($request->market_id);
        $user = User::find($order->user_id);
        $project = Project::findOrFail($order->project_id);
        if($order->type === 'BID'){
            if($project->use_tokens){

            }else{
                $client = new \GuzzleHttp\Client();
                $request = $client->request('GET',$this->uri.'/investment/transaction',[
                    'query'=>['user_id'=> $user->id,'project_id'=>$order->project_id,'securityTokens'=>$order->amount_of_shares,'project_address'=>$order->project->wallet_address]
                ]);
                $response = $request->getBody()->getContents();
                $balance = json_decode($response);
                $order->is_money_received = 1;
                $order->save();
            }
        }else{
            $client = new \GuzzleHttp\Client();
            $request = $client->request('POST',$this->uri.'/investment/transaction/repurchase',[
                'query'=>['user_id'=> $user->id,'project_id'=>$order->project_id,'securityTokens'=>$order->amount_of_shares,'project_address'=>$order->project->wallet_address]
            ]);
            $response = $request->getBody()->getContents();
            $balance = json_decode($response);
            $order->is_money_received = 1;
            $order->save();
        }
        return redirect()->back()->withMessage('Transaction is Complete');
    }
    public function viewShareCertificate($investorRecord_id)
    {
        $color = Color::where('project_site',url())->first();
        $investRecordId = base64_decode($investorRecord_id);
        $investProjectToken = InvestorProjectToken::findOrFail($investRecordId);
        $project = Project::findOrFail($investProjectToken->project_id);
        $user = User::findOrFail($investProjectToken->user_id);
        $investment = InvestmentInvestor::where('user_id',$user->id)->where('project_id',$project->id)->get()->last();
        $result = false;
        if($project->is_wallet_tokenized){
            $client = new \GuzzleHttp\Client();
            $request = $client->request('GET',$this->uri.'/getBalance',[
                'query' => ['user_id' => $user->id,'project_id'=>$project->id]
            ]);
            $response = $request->getBody()->getContents();
            $result = json_decode($response);
            if(!isset($result->balance)){
                $result = false;
            }
        }
        return view('dashboard.users.invoiceCertificate',compact('investment','color','user','project','investing','shareEnd','shareStart','result'));
    }
    public function tokenize(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'number_of_tokens' => 'required|integer|min:100',
            'token_symbol' => 'required|alpha_num|between:3,4'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        if($request->project_id) {

            // Valid request
            $projectId = (int)$request->project_id;
            $numberOfTokens = $request->number_of_tokens;
            $tokenSymbol = $request->token_symbol;

            $projectDetails = Project::findOrFail($projectId);
            $projectHash = $projectDetails->project_site;

            // $response =  $this->konkreteClient->curlKonkrete('POST', '/api/v1/contracts/deploy', [], [
            //     'project_id' => $projectId,
            //     'project_name' => $projectHash,
            //     'token_symbol' => $tokenSymbol,
            //     'number_of_tokens' =>$numberOfTokens
            // ]);
            $client = new \GuzzleHttp\Client();
            $request = $client->request('POST',$this->uri.'/contract/deploy',[
                'query'=>['project_id'=> $projectId,'project_name'=>$projectHash,'token_symbol'=>$tokenSymbol,'number_of_tokens'=>$numberOfTokens]
            ]);
            $response = $request->getBody()->getContents();
            $balance = json_decode($response);

            $responseResult = json_decode($response);

            if($responseResult->status) {

                // Update contract address in DB
                $projectDetails->contract_address = $responseResult->data->contract_address;
                $projectDetails->token_symbol = $tokenSymbol;
                $projectDetails->save();

                return response([
                    'status' => true,
                    'message' => 'Contract deployed successfully! Please verify the contract once page is reloaded!',
                    'data' => $responseResult->data
                ], 200);

            } else {
                return response([
                    'status' => false,
                    'message' => $responseResult->message
                ], 200);
            }

        } else {
            return response()->status(400);
        }
    }

    /**
     * @param $projectId
     * @return mixed
     */
    public function duplicateProject($projectId)
    {
        // Copy Project model
        $project = Project::find($projectId);
        $projectCopy = $project->replicate(['id', 'wallet_address', 'contract_address', 'is_wallet_tokenized', 'use_tokens', 'token_symbol']);
        $projectCopy->title = $project->title . ' Copy';
        $projectCopy->slug = str_slug($project->title.' '.rand(1, 999));
        $projectCopy->created_at = Carbon::now();
        $projectCopy->updated_at = Carbon::now();
        if($project->activated_on) {
            $projectCopy->activated_on = Carbon::now();
        }
        $projectCopy->save();

        // Copy Project location
        $location = \App\Location::where('project_id', $project->id)->get()->first();
        $locationCopy = $location->replicate(['id']);
        $locationCopy->project_id = $projectCopy->id;
        $locationCopy->created_at = Carbon::now();
        $locationCopy->updated_at = Carbon::now();
        $locationCopy->save();

        // Save SPV to default
        ProjectsController::setSpvToDefault($projectCopy->id);

        // Create project media directory
        if (!file_exists('assets/documents/projects/'.$projectCopy->id)) {
            File::makeDirectory('assets/documents/projects/'.$projectCopy->id, 0775, true);
        }

        // Duplicate Investment
        $investment = Investment::where('project_id', $project->id)->get()->first();
        $investmentCopy = $investment->replicate(['id']);
        $investmentCopy->project_id = $projectCopy->id;
        $investmentCopy->created_at = Carbon::now();
        $investmentCopy->updated_at = Carbon::now();
        $investmentCopy->save();

        // Duplicate Project Configurations
        $config = ProjectConfiguration::where('project_id', $project->id)->get()->first();
        $configCopy = $config->replicate(['id']);
        $configCopy->project_id = $projectCopy->id;
        $configCopy->save();

        // Duplicate Project Configurations Partial
        $configPartial = ProjectConfigurationPartial::where('project_id', $project->id)->get()->first();
        $configPartialCopy = $configPartial->replicate(['id']);
        $configPartialCopy->project_id = $projectCopy->id;
        $configPartialCopy->save();

        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET',$this->uri.'/createProject',[
            'query' => ['project_id' => $projectCopy->id]
        ]);
        $response = $request->getBody()->getContents();
        $result = json_decode($response);
        $projectCopy->wallet_address = $result->signingKey->address;
        $projectCopy->save();

        return redirect()->back()->withMessage("<div class=\"alert alert-success text-center\">Project Duplicated Successfully with name '" . $projectCopy->title . "'.</div>");
    }
}
